<?php

namespace App\Http\Controllers\Api;

use App\Model\RechargeAmount;
use App\Model\RechargeLog;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class PayController extends BaseController
{
    //
    public function doPay(Request $request)
    {
        try {
            $user = $this->getUser();
//            return $user;
//            $data = RechargeAmount::find($gid);
            $order = $this->createOrder();
//            $sign = strtolower(md5($user->sdk_id.$user->user_id.$data->title.$order.($data->price * 100).'dopay'.env('GAMEKEY')));
            $sign = (md5($user->sdk_id.$user->user_id.'充值'.$request->coin .'金币'.$order.($request->price * 100).'dopay'.env('GAMEKEY')));
            $client = new Client();
            $params=[
                'sdkId' => $user->sdk_id,
                'userId' => $user->user_id,
                'goodsName' => '充值'.$request->coin .'金币',
//                'goodsName' => $data->title,
                'orderNo' => $order,
                'fee' => $request->price * 100,
//                'fee' => $data->price * 100,
                'extra' => 'dopay',
                'sign' => $sign
            ];
//            return 'http://114.215.106.114:8081/sdk_new/tdpay/dopay.do?' . http_build_query($params);
            //return $params;
//            $headers=[
//                'Accept'     => 'application/json',
//            ];
            $response = $client->request('GET', 'http://114.215.106.114:8081/sdk_new/tdpay/dopay.do?' . http_build_query($params));
            Log::info($response);
            return redirect()->to('http://114.215.106.114:8081/sdk_new/tdpay/dopay.do?' . http_build_query($params));
//            $res = json_decode($response->getBody(),true);
//            if($res['resultCode'] != 0000){
//                return json_decode($response->getBody(),true);
//            }
//            $r = $this->storeOrder($user->user_id,$data->price,$order,$gid);
            $r = $this->storeOrder($user->user_id,$request->price,$order,$request->coin);
            if($r['code'] == 1){
                return ['code' => 1,'msg' => '支付成功'];
            }else{
                return $r;
            }
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return ['code' => -1,'msg' => $e->getResponse()];
            }
            return ['code' => -1,'msg'=> $e->getRequest()];
        }
    }

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

    public function pay_notify(Request $request)
    {
        $rules = [
            'orderNo' => 'required',
            'porderNo' => 'required',
            'fee'    => 'required',
            'extra'  => 'required',
            'resultCode' => 'required',
            'resultDesc' => 'required',
            'sign'  => 'required'
        ];
        $this->validate($request ,$rules);

        if($request->sign != strtolower(md5($request->orderNo.$request->porderNo.$request->fee.$request->extra.$request->resultCode.env('GAMEKEY')))){
            return ['code' => -1,'msg' => '验证失败'];
        }
        try{
            if($request->resultCode == 0){
                RechargeLog::where('order',$request->orderNo)->update([
                    'status' => 1,
                    'status_des' => $request->resultDesc
                ]);
            }else{
                RechargeLog::where('order',$request->orderNo)->update([
                    'status' => $request->resultCode,
                    'status_des' => $request->resultDesc
                ]);
            }
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
    }

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
