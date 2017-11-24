<?php

namespace App\Http\Controllers\Api;

use App\Model\Player;
use App\Model\RechargeAmount;
use App\Model\RechargeLog;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PayController extends BaseController
{
    // 执行支付
    public function doPay($gid)
    {
        try {
            $user = $this->getUser();
            return $user;
            $data = RechargeAmount::find($gid);
            $order = $this->createOrder();
            $sign = strtolower(md5($user->sdk_id.$user->user_id.$data->title.$order.($data->price * 100).'dopay'.env('GAMEKEY')));
//            $sign = (md5($user->sdk_id.$user->user_id.'充值'.$request->coin .'金币'.$order.($request->price * 100).'dopay'.env('GAMEKEY')));
//            $sign = (md5($user->sdk_id.$user->user_id.'充值'.$request->coin .'金币'.$order.(100).'dopay'.env('GAMEKEY')));
//            $client = new Client();
            $params=[
                'sdkId' => $user->sdk_id,
                'userId' => $user->user_id,
//                'goodsName' => '充值'.$request->coin .'金币',
                'goodsName' => $data->title,
                'orderNo' => $order,
//                'fee' => 100,
//                'fee' => $request->price * 100,
                'fee' => $data->price * 100,
                'extra' => 'dopay',
                'sign' => $sign
            ];
//            $r = $this->storeOrder($user->user_id,$request->price,$order,$request->coin);

            $r = $this->storeOrder($user->user_id,$data->price,$order,($data->coin_num + $data->award_num));
            if($r['code'] != 1){
                return ['code' => -1,'msg' => '订单保存失败'];
            }
            return ['code' => 1,'url' => 'http://114.215.106.114:8081/sdk_new/tdpay/dopay.do?' . http_build_query($params)];
            //return $params;
//            $headers=[
//                'Accept'     => 'application/json',
//            ];
//            $response = $client->request('GET', 'http://114.215.106.114:8081/sdk_new/tdpay/dopay.do?' . http_build_query($params));
//            Log::info($response->getBody());
//            Log::info( implode(',',json_decode($response->getBody())));
//            return redirect()->to('http://114.215.106.114:8081/sdk_new/tdpay/dopay.do?' . http_build_query($params));
//            $res = json_decode($response->getBody(),true);
//            if($res['resultCode'] != 0000){
//                return json_decode($response->getBody(),true);
//            }
//            $r = $this->storeOrder($user->user_id,$data->price,$order,$gid);
//            $r = $this->storeOrder($user->user_id,$request->price,$order,$request->coin);
//            if($r['code'] == 1){
//                return ['code' => 1,'msg' => '支付成功'];
//            }else{
//                return $r;
//            }
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return ['code' => -1,'msg' => $e->getResponse()];
            }
            return ['code' => -1,'msg'=> $e->getRequest()];
        }
    }

    // 保存订单
    protected function storeOrder($uid,$fee,$order,$coin)
    {
        try {
            RechargeLog::create([
                'user_id' => $uid,
                'pay'     => $fee,
                'order'   => $order,
                'coin'    => $coin
            ]);
            return ['code' => 1,'msg' => '保存成功'];
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
    }

    // 支付异步回调
    public function pay_notify(Request $request)
    {
        $rules = [
            'orderNo'    => 'required',
            'porderNo'   => 'required',
            'fee'        => 'required',
            'extra'      => 'required',
            'resultCode' => 'required',
            'resultDesc' => 'required',
            'sign'       => 'required'
        ];
        $this->validate($request ,$rules);

        if($request->sign != strtolower(md5($request->orderNo.$request->porderNo.$request->fee.$request->extra.$request->resultCode.env('GAMEKEY')))){
            return ['code' => -1,'msg' => '验证失败'];
        }

        try{
            if($request->resultCode == 0){
                $res = RechargeLog::where('order',$request->orderNo)->update([
                    'status' => 1,
                    'status_des' => $request->resultDesc,
                    'porder_num' => $request->porderNo
                ]);
                if($res){
                    $log = RechargeLog::where('order',$request->orderNo)->first();
                    $play = Player::where('user_id',$log->user_id)->first();
                    $res  = Player::where('user_id',$log->user_id)->update([
                        'coin' => $play->coin + $log->coin
                    ]);
                    return $res ? ['code' => 1,'state' => 'success','msg' => '回调成功'] : ['code' => -1,'state' => 'fail','msg' => '回调失败'];
                }
                return ['code' => -1,'msg' => '回调失败'];
            }else{
                $res = RechargeLog::where('order',$request->orderNo)->update([
                    'status' => $request->resultCode,
                    'status_des' => $request->resultDesc,
                    'porder_num' => $request->porderNo
                ]);
                return $res ? ['code' => 1,'state' => 'success','msg' => '回调成功'] : ['code' => -1,'state' => 'fail','msg' => '回调失败'];
            }
        }catch(\Exception $e){
            Log::info('msg : '.$e->getMessage());
            return ['code' => -1,'msg' => $e->getMessage()];
        }
    }

    // 创建订单
    private function createOrder()
    {
        $order = date('YmdHis').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
        if(empty(RechargeLog::where('order',$order)->first())){
            return $order;
        }else{
            $this->createOrder();
        }
    }
}
