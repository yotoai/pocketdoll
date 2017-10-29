<?php

namespace App\Http\Controllers\Api;

use App\Model\Player;
use App\Model\RechargeAmount;
use App\Model\RechargeLog;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayController extends Controller
{
    //
    public function doPay($gid)
    {
        try {
            $user_id = $this->getUserid();
            $data = RechargeAmount::find($gid);
            $sdk_id = Player::where('user_id',$user_id)->first()->sdk_id;
            $order = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
            $sign = strtolower($sdk_id.$user_id.$data->title.'123456'.$data->price.'test'.env('GAMEKEY'));
            $client = new Client();
            $params=[
                'sdkId' => $sdk_id,
                'userId' => $user_id,
                'goodsName' => $data->title,
                'orderNo' => $order,
                'fee' => $data->price,
                'extra' => 'test',
                'sign' => $sign
            ];
            $headers=[
                'Accept'     => 'application/json',
            ];
            $response = $client->request('GET', 'http://114.215.106.114:8081/sdk_new/tdpay/dopay.do',['headers'=>$headers,'form_params'=>$params]);

            $res = $this->storeOrder($user_id,$data->price,$order,$gid);
            if($res['code'] == -1){
                return $res;
            }
            return json_decode($response->getBody(),true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return ['code' => -1,'msg' => $e->getResponse()];
            }
            return ['code' => -1,'msg'=> $e->getRequest()];
        }
    }

    protected function storeOrder($user_id,$pay,$order,$gid)
    {
        try{
            RechargeLog::create([
                'user_id' => $user_id,
                'pay'     => $pay,
                'order'   => $order,
                'coin'    => $gid,
                'time'    => date('Y-m-d H:i:s',time()),
            ]);
            return ['code' => 1];
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
    }
}
