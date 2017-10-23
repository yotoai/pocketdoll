<?php

namespace App\Http\Controllers\Api;

use App\Model\Awards;
use App\Model\Mission;
use App\Model\missionType;
use App\Model\UserMission;
use App\Model\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class MissionController extends BaseController
{
    //登录任务
    public function loginInMission()
    {
        return $this->dayMission([1,2,3,5]);
//        return Mission::join('awards','mission.award_id','=', 'awards.id')
//           ->where('type',4)
//           ->orderBy('sort')
//           ->get([
//               'mission.id as mission_id',
//               'mission.title as mission_title',
//               'awards.contents as awards_contents',
//               'mission.status as mission_status',
//               'mission.icon as mission_icon'
//           ]);
    }

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
    public function dayMission(array $type=[3,4])
    {
        $list  = [];
        $lists = [];
        $mid   = [];
        $this->restMisison();
        $datas = Redis::smembers($this->getOpenid().'_mission');
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

                if(in_array($li['id'],$mid) && !empty($mid)){
                    $lists[$k]['mission_status'] = $this->getVal($li['id']);
                }
            }
        }
        return $lists;
    }
    
    // 完成一个任务
    public function finishMission($mid)
    {
        try{
            if($this->getMissionRedis($mid) == 2){
                return ['code' => -1,'msg' => '该任务已完成！'];
            }elseif($this->getMissionType($mid) == 3 || $this->getMissionType($mid) == 4){
                $aid = Mission::where('id',$mid)->value('award_id');

                $res = Awards::where('id',$aid)->first(['award_coin','award_point']);

                $ures = Users::where('openid',$this->getOpenid())->first(['coin']);

                DB::transaction(function () use ($res,$ures,$mid){
                    Users::where('openid',$this->getOpenid())->update([
                        'coin' => $ures->coin + $res->award_coin,
                    ]);
                    UserMission::create([
                        'user_id'    => $this->getOpenid(),
                        'mission_id' => $mid,
                        'status'     => '1'
                    ]);
                });
                $this->setMissionRedis($mid,2);
                return ['code' => 1,'msg' => '完成'];
            }else{
                $aid = Mission::where('id',$mid)->value('award_id');

                $res = Awards::where('id',$aid)->first(['award_coin','award_point']);

                $ures = Users::where('openid',$this->getOpenid())->first(['coin']);

                DB::transaction(function () use ($res,$ures,$mid){
                    Users::where('openid',$this->getOpenid())->update([
                        'coin' => $ures->coin + $res->award_coin,
                    ]);
                    UserMission::create([
                        'user_id'    => $this->getOpenid(),
                        'mission_id' => $mid,
                        'status'     => '1'
                    ]);
                });
                $this->setMissionRedis($mid,2);
                $this->setPointRedis($res->award_point);
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
                    ])->toArray()[0];
                $this->addRedisMission($data['mission_id']);
                return ['code' => 1,'msg' => '完成','point' => $res->award_point,'data' => $data];
            }
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
    }
    
    // 初始化 每日任务
    public function restMisison()
    {
        if(Users::where('openid',$this->getOpenid())->value('new_user_mission') == '1'){
            $data = Mission::where('parent_id',0)->where('type','<>',3)
                ->orderBy('mission.id')->get(['id','status'])->toArray();
            foreach ($data as $da){
                Redis::sadd($this->getOpenid().'_mission',serialize($da) );
            }
        }else{
            $data = Mission::where('parent_id',0)
                ->orderBy('mission.id')->get(['id','status'])->toArray();
            foreach ($data as $da){
                Redis::sadd($this->getOpenid().'_mission',serialize($da) );
            }
        }
    }

    // 向任务列表添加任务
    public function addRedisMission($mid)
    {
        Redis::sadd($this->getOpenid().'_mission',serialize([
            'id'     => $mid,
            'status' => '0'
        ]));
    }

    // 判断任务类型
    protected function getMissionType($mid)
    {
        return Mission::find($mid)->type;
    }
}
