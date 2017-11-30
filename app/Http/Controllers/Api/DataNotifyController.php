<?php

namespace App\Http\Controllers\Api;

use App\Model\catchLog;
use App\Model\Player;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class DataNotifyController extends Controller
{
    // 用户回调
    public function userNotify(Request $request)
    {
//        $this->validate($request,[
//            'identification' => 'required',
//            'sign' => 'required'
//        ]);
//        if(strtolower(md5(env('NOTIFYCODE'))) != $request->sign){
//            return ['code' => -1,'status' => 'fail','msg' => '回调失败'];
//        }
        try{
            $data = Player::whereBetween('created_at',[date('Y-m-d 00:00:00'),date('Y-m-d H:i:s',time())])
                ->get([
                    'user_id',
                    'user_name',
                    'user_img',
                    'coin',
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
//        $this->validate($request,[
//            'identification' => 'required',
//            'sign' => 'required'
//        ]);
//        if(strtolower(md5(env('NOTIFYCODE'))) != $request->sign){
//            return ['code' => -1,'status' => 'fail','msg' => '回调失败'];
//        }
        try{
            $data = catchLog::join('player','player.user_id','=','catchdoll_log.user_id')
                ->join('goods','goods.id','=','catchdoll_log.goods_id')
                ->whereBetween('catchdoll_log.created_at',[date('Y-m-d 00:00:00'),date('Y-m-d H:i:s',time())])
                ->get([
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

    // 返佣增加用户金币
    public function addRebateCoin(Request $request)
    {
        $this->validate($request,[
            'userId' => 'required',
        ]);
        $user = Player::find($request->userId);
        $user->coin = $user->coin + $request->coin;
        $user->save();
    }

}
