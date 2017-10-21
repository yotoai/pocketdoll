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
       return Mission::join('awards','mission.award_id','=', 'awards.id')
           ->where('type',4)
           ->orderBy('sort')
           ->get([
               'mission.id as mission_id',
               'mission.title as mission_title',
               'awards.contents as awards_contents',
               'mission.status as mission_status',
               'mission.icon as mission_icon'
           ]);
    }

    /*
     * 每日任务
     * 初始化任务存入Redis ： Reids::sadd('user_mission',['mission_id' => id,'status' => [0,1,2]]);
     * 查出任务 ： Redis::smembers('user_mission');
     * 修改 任务状态或者添加新的任务,先 Redis::del('user_mission'); 然后在sadd 新的数组
     * 点击任务按钮时，返回 Redis::smembers('user_missoon');
     * { 还是待改东西... }
     * */
    public function dayMission()
    {
//        $data = Mission::whereNotIn('type',[3,4])
//            ->where('parent_id',0)
//            ->orderBy('mission.id')->get(['id','status'])->toArray();
//        foreach ($data as $da){
//            Redis::sadd($this->getOpenid().'_mission',serialize($da) );
//        }
        $datas = Redis::smembers($this->getOpenid().'_mission');
        $list = [];
        foreach ($datas as $ds){
            $list[] = unserialize($ds);
        }
        $lists = [];
        $keys = $this->getKeys('mission');
        foreach ($keys as $key=>$val) {
            $values[] = $this->getValues($val);
            $mid[] = explode('_',$val)[1];
        }
       // return in_array(2,$mid) ? 1 : 2;
       // return $list;
        foreach ($list as $k=>$li){
            $lists[] = Mission::join('awards','mission.award_id','=', 'awards.id')
                ->whereNotIn('type',[3,4])
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
            if(in_array($li['id'],$mid)){
                $lists[$k]['mission_status'] = $this->getVal($li['id']);
            }
        }
        return $lists;


        if(empty($keys)){
            $list[] = Mission::join('awards','mission.award_id','=', 'awards.id')
                    ->whereNotIn('type',[3,4])
                    ->where('parent_id',0)
                    ->orderBy('mission.id')
                    ->get([
                        'mission.id as mission_id',
                        'mission.type as mission_type',
                        'mission.title as mission_title',
                        'awards.contents as awards_contents',
                        'mission.status as mission_status',
                        'mission.icon as mission_icon',
                        'mission.need_num as mission_need_num'
                    ]);
            return $list;

        }else{
            $values = [];
            $list = [];
            $pid = Mission::where('parent_id',0)->whereNotIn('type',[3,4])->get(['id']);
            foreach ($keys as $key=>$v){
                $values[] = $this->getValues($v);
                $mid = explode('_',$v)[1];

                if(in_array($mid ,$pid)){
                    $list[] = Mission::join('awards','mission.award_id','=', 'awards.id')
                        ->whereNotIn('type',[3,4])
                        ->where('mission.id',$mid)
                        ->orderBy('mission.id')
                        ->get([
                            'mission.id as mission_id',
                            'mission.type as mission_type',
                            'mission.title as mission_title',
                            'awards.contents as awards_contents',
                            'mission.icon as mission_icon',
                            'mission.need_num as mission_need_num'
                        ])[0];
                    $list[$key]['mission_status'] = $values[$key];
                    if($values[$key] == 2){
                        $list[] = Mission::where('parent_id',$mid)->first()->id;
                    }
                }


                $list[] = Mission::join('awards','mission.award_id','=', 'awards.id')
                    ->whereNotIn('type',[3,4])
                    ->where('mission.id',$mid)
                    ->orderBy('mission.id')
                    ->get([
                        'mission.id as mission_id',
                        'mission.type as mission_type',
                        'mission.title as mission_title',
                        'awards.contents as awards_contents',
                        'mission.icon as mission_icon',
                        'mission.need_num as mission_need_num'
                    ])[0];
                $list[$key]['mission_status'] = $values[$key];

                if($values[$key] == 2){
                    $list[] = Mission::where('parent_id',$mid)->first()->id;
                }
            }
            return $pid;
        }
    }
    
    // 完成一个任务
    public function finishMission($mid)
    {
        try{
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
            if($this->getMissionRedis($mid) == 2){
                return ['code' => -1,'msg' => '该任务已完成！'];
            }else{
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
                    ])->toArray()[0];;
                $this->addRedisMission($data['mission_id']);
                return ['code' => 1,'msg' => '完成','point' => $res->award_point,'data' => $data];
            }
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
    }
    
    // 初始化 任务
    public function restMisison()
    {
        $data = Mission::where('parent_id',0)
            ->orderBy('mission.id')->get(['id','status'])->toArray();
        foreach ($data as $da){
            Redis::sadd($this->getOpenid().'_mission',serialize($da) );
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
    
    

    // 添加个任务
    public function addMission(Request $request)
    {
        $rules = [
            'contents' => 'required|max:255',
            'award_id' => 'required|integer',
            'type'     => 'required|integer',
            'need_num' => 'required|integer'
        ];
        $this->validate($request,$rules);
        $pic = $this->filesUpload($request);
        try{
            $res = Mission::create([
                'contents' => $request->contents,
                'award_id' => $request->award_id,
                'type'     => $request->type,
                'need_num' => $request->need_num,
                'icon'     => $pic
            ]);
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        return $res ? ['code' => 1,'msg' => '添加成功！'] : ['code' => -1,'msg' => '添加失败！'];
    }

    // 修改的任务
    public function updateMission(Request $request,$id)
    {
        $rules = [
            'contents' => 'required|max:255',
            'award_id' => 'required|integer',
            'type'     => 'required|integer',
            'need_num' => 'required|integer'
        ];
        $this->validate($request,$rules);
        $pic = $this->filesUpload($request);
        try{
            $res = Mission::where('id',$id)->update([
                'contents' => $request->contents,
                'award_id' => $request->award_id,
                'type'     => $request->type,
                'need_num' => $request->need_num,
                'icon'     => $pic
            ]);
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        return $res ? ['code' => 1,'msg' => '修改成功！'] : ['code' => -1,'msg' => '修改失败！'];
    }

    // 删除个任务
    public function deleteMission($id)
    {
        $res = Mission::where('id',$id)->delete();
        return $res ? ['code' => 1,'msg' => '删除成功！'] : ['code' => -1,'msg' => '删除失败！'];
    }

    // 任务分类
    public function missionType()
    {
        return missionType::all()->toArray();
    }

    // 添加个任务分类
    public function addMissionType(Request $request)
    {
        $rules = [
            'title' => 'required|max:255'
        ];
        $this->validate($request,$rules);
        try{
            $res = missionType::create([
                'title' => $request->title
            ]);
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        return $res ? ['code' => 1,'msg' => '添加成功！'] : ['code' => -1,'msg' => '添加失败！'];
    }
}
