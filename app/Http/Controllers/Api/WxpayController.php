<?php

namespace App\Http\Controllers\Api;

use App\Model\Mission;
use App\Model\RechargeAmount;
use App\Model\RechargeLog;
use App\Model\Users;
use Carbon\Carbon;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WxpayController extends BaseController
{
    //
//    protected function __construct()
//    {
//        $this->payment = (new Application(config('wechat')))->payment;
//    }

    // 订单支付
    public function Wxpay($id)
    {
        $ra  = RechargeAmount::findOrfail(intval($id));
        $oauth = session('wechat.oauth_user')->toArray();
        $out_trade_no = md5(Carbon::now().str_random(8));
        $attributes = [
            'trade_type'   => 'JSAPI',
            'body'         => $ra->title,
            'out_trade_no' => $out_trade_no,
            'total_fee'    => $ra->price * 100,
            'notify_url'   => $_ENV['APP_URL'].'/api/wxnotify',
            'openid'       => $oauth['id']
        ];
        $order = new Order($attributes);
        $payment = (new Application(config('wechat')))->payment;
        $res = $payment->prepare($order);
        if($res->return_code == 'SUCCESS' && $res->result_code == 'SUCCESS')
        {
            try{
                $user = Users::where('openid',$oauth['id'])->first(['coin','point']);
                DB::transaction(function() use ($out_trade_no,$oauth,$ra,$user){
                    RechargeLog::create([
                        'order'   => $out_trade_no,
                        'user_id' => $oauth['id'],
                        'coin'    => $ra->coin_num,
                        'pay'     => $ra->price
                    ]);
                    Users::where('openid',$oauth['id'])->update([
                        'coin'  => $ra->coin_num + $user->coin,
                        'point' => $ra->point + $user->point
                    ]);
                });
            }catch (\Exception $e){
                return ['code' => -1,'msg' => $e->getMessage()];
            }
            $prepayId = $res->prepay_id;
            $config = $payment->configForPayment($prepayId,false);
            return $config;
        }
    }

    // 回调
    public function wxNotify()
    {
        $payment = (new Application(config('wechat')))->payment;
        $response = $payment->handleNotify(function($notify, $successful){
            $order = RechargeLog::where('order', $notify->out_trade_no)->first();
            if (!$order) {
                return ['code' => -1,'msg' => '订单不存在！']; // 如果订单不存在
            }
            if ($order->time) {
                $this->setChargeNum(1);
                $this->finishChargeMission();
                return true; // 已经支付成功了就不再更新了
            }
            if ($successful) {
                $order->time = Carbon::now();  // 更新支付时间为当前时间
                $order->status = '1';
            } else {
                $order->status = '-99';  // 用户支付失败
            }
            $order->save(); // 保存订单
            return true;
        });
        return $response;
    }

    // 完成 充值任务
    public function finishChargeMission()
    {
        $num = $this->getChargeNum();
        $res = Mission::where('type',1)->get(['id','need_num']);
        foreach ($res as $v){
            if($v->need_num == $num && $this->getMissionRedis($v->id) != 1){
                $this->setMissionRedis($v->id,1);
            }
        }
    }
}
