<?php

namespace App\Http\Controllers\Api;

use App\Model\Awards;
use App\Model\Goods;
use App\Model\Mission;
use App\Model\missionType;
use App\Model\Player;
use App\Model\PointLog;
use App\Model\UserMission;
use App\Model\UserRucksack;
use App\Model\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class MissionController extends BaseController
{
    //登录任务
    public function loginInMission()
    {
        $datas = $this->getLoginMission();
        $list = [];
        foreach ($datas as $ds){
            $list[] = unserialize($ds);
        }

        $lists = [];
        foreach ($list as $k=>$li){
            $temp = Mission::join('awards','mission.award_id','=', 'awards.id')
                ->where('type',4)
                ->where('mission.id',$li['id'])
                ->orderBy('mission.need_num','asc')
                ->get([
                    'mission.id as mission_id',
                    'mission.type as mission_type',
                    'mission.title as mission_title',
                    'awards.contents as awards_contents',
                    'mission.status as mission_status',
                    'mission.icon as mission_icon',
                    'mission.need_num as mission_need_num'
                ])[0];
            $temp->mission_status = $li['status'];
            $temp->mission_icon = env('APP_URL').'/uploads/'.$temp->mission_icon;
            $lists[] = $temp;
        }
        sort($lists);
        return ['code' => 1,'msg' => '查询成功','data' => $lists];
    }

    // 邀请任务
    public function inviteMission()
    {
        return $this->dayMission([1,2,4,5]);
    }
    /*
     * 每日任务
     * 初始化任务存入Redis ： Reids::sadd('user_mission',['mission_id' => id,'status' => [0,1,2]]);
     * 查出任务 ： Redis::smembers('user_mission');
     * 修改 任务状态或者添加新的任务,先 Redis::del('user_mission'); 然后在sadd 新的数组
     * 点击任务按钮时，返回 Redis::smembers('user_missoon');
     * { 还是待改东西... }
     * */
    public function dayMission(array $type=[4])
    {
        $list  = [];
        $lists = [];
        $mid   = [];
        $this->restMisison();
        $datas = Redis::smembers($this->getUserid().'_mission');
        foreach ($datas as $ds){
            $list[] = unserialize($ds);
        }
        if(!empty($keys = $this->getKeys('mission'))){
            foreach ($keys as $key=>$val) {
                $mid[] = explode('_',$val)[1];
            }
        }
        foreach ($list as $k=>$li){
            if(!in_array($this->getMissionType($li['id']),$type)){
                $lists[] = Mission::join('awards','mission.award_id','=', 'awards.id')
                    ->whereNotIn('type',$type)
                    ->where('mission.id',$li['id'])
                    ->orderBy('mission.id')
                    ->get([
                        'mission.id as mission_id',
                        'mission.type as mission_type',
                        'mission.title as mission_title',
                        'awards.contents as awards_contents',
                        'mission.status as mission_status',
                        'mission.icon as mission_icon',
                        'mission.need_num as mission_need_num'
                    ])[0];
            }
        }

        foreach ($lists as $ks =>$ls){
            $ls->mission_icon = env('APP_URL').'/uploads/'.$ls->mission_icon;
            if(in_array($ls->mission_id,$mid) && !empty($mid)){
                $lists[$ks]['mission_status'] = $this->getVal($ls->mission_id);
            }
            if($ls->mission_type == 2 ){
                $lists[$ks]['finish_num'] = empty($this->getCatchNum()) ? 0 : $this->getCatchNum();
            }elseif($ls->mission_type == 1){
                $lists[$ks]['finish_num'] = empty($this->getChargeNum()) ? 0 : $this->getChargeNum();
            }elseif($ls->mission_type == 5){
                $lists[$ks]['finish_num'] = empty($this->getCatchedNum()) ? 0 : $this->getCatchedNum();
            }elseif($ls->mission_type == 3){
                $lists[$ks]['finish_num'] = empty($this->getShareNum()) ? 0 : $this->getShareNum();
            }
        }
        return ['code' => 1,'msg' => '查询成功','data' => $lists];
    }
    
    // 完成一个任务
    public function finishMission($mid)
    {
        try{
            if($this->getMissionRedis($mid) == 2){
                return ['code' => -1,'msg' => '该任务已完成！'];
            }elseif($this->getMissionType($mid) == 4){
                $aid = Mission::where('id',$mid)->value('award_id');

                $res = Awards::where('id',$aid)->first(['award_coin','award_point']);

                $ures = Player::where('user_id',$this->getUserid())->first(['coin']);

                DB::transaction(function () use ($res,$ures,$mid){
                    Player::where('user_id',$this->getUserid())->update([
                        'coin' => $ures->coin + $res->award_coin,
                    ]);
                    UserMission::create([
                        'user_id'    => $this->getUserid(),
                        'mission_id' => $mid,
                        'status'     => '1'
                    ]);
                    $this->addPoint($res->award_point);
                });
                $datas = $this->getLoginMission();
                $list = [];
                foreach ($datas as $ds){
                    $list[] = unserialize($ds);
                }
                sort($list);
                Redis::del($this->getUserid().'_login_missions');
                foreach ($list as $da){
                    if($mid == $da['id']){
                        $da['status'] = '2';
                    }
                    Redis::sadd($this->getUserid().'_login_missions',serialize($da) );
                    if(!$this->isHaveMission($mid)){
                        Player::where('user_id',$this->getUserid())->update([
                            'new_user_mission' => '1'
                        ]);
                    }
                }
                Redis::set($this->getUserid().'_isdraw',1);
                return ['code' => 1,'msg' => '完成任务'];
            }elseif($this->getMissionType($mid) == 3){
                $aid = Mission::where('id',$mid)->value('award_id');

                $res = Awards::where('id',$aid)->first(['award_coin','award_point']);

                $ures = Player::where('user_id',$this->getUserid())->first();

                DB::transaction(function () use ($res,$ures,$mid){
                    Player::where('user_id',$this->getUserid())->update([
                        'coin' => $ures->coin + $res->award_coin,
                    ]);
                    UserMission::create([
                        'user_id'    => $this->getUserid(),
                        'mission_id' => $mid,
                        'status'     => '1'
                    ]);
                    $this->addPoint($res->award_point);
                });
                $this->setMissionRedis($mid,2);
                return ['code' => 1,'msg' => '完成任务'];
            }else{
                $aid = Mission::where('id',$mid)->value('award_id');// 从任务表中获取奖励id

                $res = Awards::where('id',$aid)->first(['award_coin','award_point']); // 从奖励表获取 奖励的金币和积分

                $ures = Player::where('user_id',$this->getUserid())->first(['coin']);// 从用户表获取用户金币

                DB::transaction(function () use ($res,$ures,$mid){
                    Player::where('user_id',$this->getUserid())->update([
                        'coin' => $ures->coin + $res->award_coin,
                    ]); // 添加金币
                    UserMission::create([
                        'user_id'    => $this->getUserid(),
                        'mission_id' => $mid,
                        'status'     => '1'
                    ]); // 创建任务日志
                });
                $this->setMissionRedis($mid,2);

//                $this->setPointRedis($res->award_point);
                $this->addPoint($res->award_point);
                $data = Mission::join('awards','mission.award_id','=', 'awards.id')
                    ->whereNotIn('type',[3,4])
                    ->where('mission.parent_id',$mid)
                    ->orderBy('mission.id')
                    ->get([
                        'mission.id as mission_id',
                        'mission.type as mission_type',
                        'mission.title as mission_title',
                        'awards.contents as awards_contents',
                        'mission.icon as mission_icon',
                        'mission.need_num as mission_need_num',
                        'mission.status as mission_status'
                    ])->toArray();
                if(!empty($data)){
                    $data = $data[0];
                    if($this->getMissionType($mid) == 2){
                        if($this->getCatchNum() >= $data['mission_need_num']){
                            $data['mission_status'] = 1;
                            $this->addRedisMission($data['mission_id'],1);
                        }else{
                            $this->addRedisMission($data['mission_id']);
                        }
                    }elseif($this->getMissionType($mid) == 5){
                        if($this->getCatchedNum() >= $data['mission_need_num']){
                            $data['mission_status'] = 1;
                            $this->addRedisMission($data['mission_id'],1);
                        }else{
                            $this->addRedisMission($data['mission_id']);
                        }
                    }elseif ($this->getMissionType($mid) == 1){
                        if($this->getChargeNum() >= $data['mission_need_num']){
                            $data['mission_status'] = 1;
                            $this->addRedisMission($data['mission_id'],1);
                        }else{
                            $this->addRedisMission($data['mission_id']);
                        }
                    }
                    $data['mission_icon'] = env('APP_URL').'/uploads/'.$data['mission_icon'];
                }
                return ['code' => 1,'msg' => '任务完成','point' => $res->award_point,'data' => $data];
            }
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage(),'ss' => $e->getLine()];
        }
    }
    
    // 初始化 每日任务
    public function restMisison()
    {
//        if(Player::where('user_id',$this->getUserid())->value('new_user_mission') != '1'){
//            $data = Mission::where('parent_id',0)->where('type','<>',4)
//                ->orderBy('mission.id')->get(['id','status'])->toArray();
//            foreach ($data as $da){
//                Redis::sadd($this->getUserid().'_mission',serialize($da) );
//            }
//        }else{
            $data = Mission::where('parent_id',0)
                ->orderBy('mission.id')->get(['id','status'])->toArray();
            foreach ($data as $da){
                Redis::sadd($this->getUserid().'_mission',serialize($da) );
            }
//        }
    }

    // 向任务列表添加任务
    public function addRedisMission($mid,$status=0)
    {
        Redis::sadd($this->getUserid().'_mission',serialize([
            'id'     => $mid,
            'status' => $status
        ]));
    }

    // 判断任务类型
    protected function getMissionType($mid)
    {
        return Mission::find($mid)->type;
    }
    
    // 判断之后是否有任务
    protected function isHaveMission($mid)
    {
        $c = Mission::where('type',4)->where('id','>',$mid)->count();
        return $c ? true : false;
    }

    // 增加 积分
    protected function addPoint($point)
    {
        $user = Player::where('user_id',$this->getUserid())->first();
        $user->point = $user->point + $point;
        $user->save();
        $this->addPointLog('任务通道',$point); //增加记录
    }

    // 增加积分记录
    protected function addPointLog($way,$point)
    {
        try{
            $user = Player::where('user_id',$this->getUserid())->first();
            PointLog::create([
                'sdk_id' => $user->sdk_id,
                'user_id' => $user->user_id,
                'user_name' => $user->user_name,
                'point_num' => $point,
                'get_way' => $way
            ]);
        }catch (\Exception $e){
            Log::info('error_place : addPointLog msg : '.$e->getMessage().'  line : '.$e->getLine());
        }
    }

    // 获取用户积分
    public function getUserPoint()
    {
        $point = Player::where('user_id',$this->getUserid())->first();
        return [
            'code' => 1,
            'msg' => '查询成功',
            'current_point' => ($point->point >= 100) ? 100 : $point->point,
            'max_point' => 100,
            'status' => ($point->point >= 100) ? 1 : 0
        ];
    }

    // 兑换娃娃
    public function exchangeDoll()
    {
        try{
            $uid = $this->getUserid();
            $user = Player::where('user_id',$uid)->first();
            if($user->point < 100){
                return ['code' => -1,'msg' => '积分不足'];
            }
            $goods = Goods::where('status','<>','-1')->orderBy(DB::raw('RAND()'))->take(1)->get(['id as goods_id','name as goods_name','pic as goods_pic'])[0];
            $res = UserRucksack::where('user_id',$uid)->where('goods_id',$goods->goods_id)->first();
            if(!empty($res) && $res->goods_id == $goods->goods_id) {
                $re = UserRucksack::where('user_id',$uid)->where('goods_id',$goods->goods_id)->update([
                    'num' => $res->num + 1
                ]);
            }else {
                $re = UserRucksack::create([
                    'user_id'   => $uid,
                    'goods_id'  => $goods->goods_id,
                    'num'       => 1,
                    'gain_time' => date('Y-m-d H:i:s', time())
                ]);
            }
            if($re){
                UserMission::create([
                    'user_id'    => $this->getUserid(),
                    'mission_id' => -11, // 特殊任务
                    'status'     => '1'
                ]);
                $user->point = $user->point - 100;
                $user->save();  // 减少积分
                $goods->goods_pic = env('APP_URL') . '/uploads/' . $goods->goods_pic;
                return ['code' => 1,'msg' => '兑换成功','data' => $goods];
            }else{
                return ['code' => -1,'msg' => '兑换失败'];
            }

        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
    }
}
