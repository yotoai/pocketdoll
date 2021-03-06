<?php

namespace App\Http\Controllers\Api;

use App\Model\catchLog;
use App\Model\DollMachineLog;
use App\Model\GoodsCategory;
use App\Model\Player;
use App\Model\PointLog;
use App\Model\RechargeLog;
use App\Model\ShareLog;
use App\Model\UserMission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class DataNotifyController extends Controller
{
    // 用户信息回调
    public function userNotify(Request $request)
    {
        $this->validate($request,[
            'identification' => 'required',
            'sign' => 'required'
        ]);
        if(strtolower(md5('UserGet' . env('GAMEKEY'))) != $request->sign){
            return ['code' => -1,'status' => 'fail','msg' => '验证失败'];
        }
        try{
            $data = Player::
            whereBetween('login_time',$this->yesterday())
                ->get([
                    'sdk_id',
                    'user_id',
                    'user_name',
                    'user_img',
                    'coin',
                    'used_coin',
                    'point',
                    'login_time',
                    'created_at as create_time'
                ])->toArray();
            if(!empty($data)){
                return ['code' => 1,'status' => 'success','data' => $data];
            }else{
                return ['code' => 1,'status' => 'success','data' => ''];
            }
        }catch (\Exception $e){
            Log::info('action:userNotify , error:'.$e->getMessage());
            return ['code' => -1,'status' => 'fail','msg' => '回调失败'];
        }
    }

    // 抓取回调
    public function catchLogNotify(Request $request)
    {
        $this->validate($request,[
            'identification' => 'required',
            'sign' => 'required'
        ]);
        if(strtolower(md5('CatchLog' . env('GAMEKEY'))) != $request->sign){
            return ['code' => -1,'status' => 'fail','msg' => '验证失败'];
        }
        try{
            $data = catchLog::join('player','player.user_id','=','catchdoll_log.user_id')
                ->join('goods','goods.id','=','catchdoll_log.goods_id')
                ->whereBetween('catchdoll_log.created_at',$this->yesterday())
                ->get([
                    'player.sdk_id as sdk_id',
                    'player.user_id as user_id',
                    'player.user_name as user_name',
                    'goods.name as doll_name',
                    'catchdoll_log.status as status',
                    'catchdoll_log.created_at as catched_time'
                ])->toArray();
            if(!empty($data)){
                foreach ($data as $key=>$d){
                    if($d['status'] == '1'){
                        $data[$key]['status'] = '已提现';
                    }else{
                        $data[$key]['status'] = '未提现';
                    }
                }
                return ['code' => 1,'status' => 'success','data' => $data];
            }else{
                return ['code' => 1,'status' => 'success','data' => ''];
            }
        }catch (\Exception $e){
            Log::info('action:userNotify , error:'.$e->getMessage());
            return ['code' => -1,'status' => 'fail','msg' => $e->getMessage()];
        }
    }

    // 娃娃机抓取记录回调
    public function DollMachineLogNotify(Request $request)
    {
        $this->validate($request,[
            'identification' => 'required',
            'sign' => 'required'
        ]);
        if(strtolower(md5('DollMachineLog' . env('GAMEKEY'))) != $request->sign){
            return ['code' => -1,'status' => 'fail','msg' => '验证失败'];
        }
        try{
            $data = DollMachineLog::get([
                    'sdk_id',
                    'doll_machine_id',
                    'doll_machine_name',
                    'catch_num',
                    'catched_num',
                    'lucky_model_catch_num',
                    'created_at as create_time'
                ])->toArray();
            return ['code' => 1,'status' => 'success','data' => $data];
        }catch (\Exception $e){
            Log::info('action:DollMachineLogNotify , error:'.$e->getMessage());
            return ['code' => -1,'status' => 'fail','msg' => $e->getMessage()];
        }
    }

    // 娃娃机列表回调
    public function DollMachineNotify(Request $request)
    {
        $this->validate($request,[
            'identification' => 'required',
            'sign' => 'required'
        ]);
        if(strtolower(md5('DollMachine' . env('GAMEKEY'))) != $request->sign){
            return ['code' => -1,'status' => 'fail','msg' => '验证失败'];
        }
        try{
            $data = GoodsCategory::get([
                'id as doll_machine_id',
                'cate_name as doll_machine_name',
                'created_at as create_time'
            ])->toArray();
            return ['code' => 1,'status' => 'success','data' => $data];
        }catch (\Exception $e){
            Log::info('action:DollMachineNotify , error:'.$e->getMessage());
            return ['code' => -1,'status' => 'fail','msg' => $e->getMessage()];
        }
    }

    // 积分记录回调
    public function PointLogNotify(Request $request)
    {
        $this->validate($request,[
            'identification' => 'required',
            'sign' => 'required'
        ]);
        if(strtolower(md5('PointLog' . env('GAMEKEY'))) != $request->sign){
            return ['code' => -1,'status' => 'fail','msg' => '验证失败'];
        }
        try{
            $data = PointLog::whereBetween('created_at',$this->yesterday())
                ->get([
                    'sdk_id',
                    'user_id',
                    'user_name',
                    'point_num',
                    'get_way',
                    'created_at as get_time'
                ])->toArray();
            return ['code' => 1,'status' => 'success','data' => $data];
        }catch (\Exception $e){
            Log::info('action:PointLogNotify , error:'.$e->getMessage());
            return ['code' => -1,'status' => 'fail','msg' => $e->getMessage()];
        }
    }
    // get_way后期有 : 分享通道，充值通道，任务通道，邀请通道，活动通道，礼包通道


    // 分享记录回调
    public function ShareLogNotify(Request $request)
    {
        $this->validate($request,[
            'identification' => 'required',
            'sign' => 'required'
        ]);
        if(strtolower(md5('ShareLog' . env('GAMEKEY'))) != $request->sign){
            return ['code' => -1,'status' => 'fail','msg' => '验证失败'];
        }
        try{
            $data = ShareLog::whereBetween('created_at',$this->yesterday())
                ->get([
                    'sdk_id',
                    'user_id',
                    'user_name',
                    'share_num',
                    'share_type',
                    'created_at as first_share_time'
                ])->toArray();
            return ['code' => 1,'status' => 'success','data' => $data];
        }catch (\Exception $e){
            Log::info('action:ShareLogNotify , error:'.$e->getMessage());
            return ['code' => -1,'status' => 'fail','msg' => $e->getMessage()];
        }
    }

    // 充值记录回调
    public function rechargeLogNotify(Request $request)
    {
        $this->validate($request,[
            'identification' => 'required',
            'sign' => 'required'
        ]);
        if(strtolower(md5('RechargeLog' . env('GAMEKEY'))) != $request->sign){
            return ['code' => -1,'status' => 'fail','msg' => '验证失败'];
        }
        try{
            $data = RechargeLog::join('player','player.user_id','=','recharge_log.user_id')
                ->whereBetween('recharge_log.created_at',$this->yesterday())
                ->get([
                    'player.sdk_id as sdk_id',
                    'player.user_id as user_id',
                    'player.user_name as user_name',
                    'recharge_log.order as order_num',
                    'recharge_log.pay as pay',
                    'recharge_log.coin as coin_num',
                    'recharge_log.status as status',
                    'recharge_log.status_des as status_des',
                    'recharge_log.time as pay_time',
                    'recharge_log.created_at as create_time'
                ])->toArray();
            if(!empty($data)){
                foreach ($data as $key=>$d){
                    if($d['status'] == '1'){
                        $data[$key]['status'] = '支付成功';
                    }else{
                        $data[$key]['status'] = '支付失败';
                    }
                }
                return ['code' => 1,'status' => 'success','data' => $data];
            }else{
                return ['code' => 1,'status' => 'success','data' => ''];
            }
        }catch (\Exception $e){
            Log::info('action:rechargeLogNotify , error:'.$e->getMessage());
            return ['code' => -1,'status' => 'fail','msg' => $e->getMessage()];
        }
    }

    // 完成的任务回调
    public function missionedNotify(Request $request)
    {
        $this->validate($request,[
            'identification' => 'required',
            'sign' => 'required'
        ]);
        if(strtolower(md5('CompletedMission' . env('GAMEKEY'))) != $request->sign){
            return ['code' => -1,'status' => 'fail','msg' => '验证失败'];
        }
        try{
            $data = UserMission::join('player','player.user_id','=','user_mission.user_id')
                ->join('mission','mission.id','=','user_mission.goods_id')
                ->whereBetween('user_mission.created_at',$this->yesterday())
                ->get([
                    'player.sdk_id as sdk_id',
                    'player.user_name as user_name',
                    'mission.title as mission_name',
                    'user_mission.status as status',
                    'user_mission.created_at as finished_time'
                ])->toArray();
            if(!empty($data)){
                foreach ($data as $key=>$d){
                    if($d['status'] == '1'){
                        $data[$key]['status'] = '已完成';
                    }else{
                        $data[$key]['status'] = '未完成';
                    }
                }
                return ['code' => 1,'status' => 'success','data' => $data];
            }else{
                return ['code' => 1,'status' => 'success','data' => ''];
            }
        }catch (\Exception $e){
            Log::info('action:userNotify , error:'.$e->getMessage());
            return ['code' => -1,'status' => 'fail','msg' => $e->getMessage()];
        }
    }

    // 返佣增加用户金币
    public function addRebateCoin(Request $request)
    {
        $this->validate($request,[
            'userId' => 'required',
            'coin' => 'required',
            'sign' => 'required'
        ]);
        if(strtolower(md5($request->userId . $request->coin . env('GAMEKEY'))) != $request->sign){
            return ['code' => -1,'status' => 'fail','errorMsg' => '验证失败'];
        }
        try{
            $user = Player::where('user_id',$request->userId)->first();
            $res = Player::where('user_id',$request->userId)
                ->update([
                    'coin' => $user->coin + $request->coin
                ]);
            if($res){
                return ['code' => 1,'status' => 'success','Msg' => '添加金币成功'];
            }else{
                return ['code' => -1,'status' => 'fail','errorMsg' => '添加金币失败'];
            }
        }catch (\Exception $e){
            return ['code' => -1,'status','fail','errorMsg' => $e->getMessage()];
        }
    }

    protected function yesterday()
    {
        $yesterday = date('d') - 1;
        return [
            date('Y-m-d H:i:s',mktime(0, 0, 0, date('m'), $yesterday, date('Y'))),
            date('Y-m-d H:i:s',mktime(23, 59, 59, date('m'), $yesterday, date('Y')))
        ];
    }
}
