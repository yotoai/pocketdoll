<?php

namespace App\Http\Controllers\Api;

use App\Model\Awards;
use App\Model\Mission;
use App\Model\missionType;
use App\Model\Users;
use Illuminate\Http\Request;
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

    // 每日任务
    public function dayMission()
    {
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
    }
    
    // 完成一个任务
    public function finishMission($mid)
    {
        try{
            $aid = Mission::where('id',$mid)->value('award_id');
            $res = Awards::where('id',$aid)->first(['award_coin','award_point']);
            $ures = Users::where('openid',$this->getOpenid())->first(['coin']);
            Users::where('openid',$this->getOpenid())->update([
                'coin' => $ures->coin + $res->award_coin,
            ]);
            $p = Redis::get($this->getPointKey());
            Redis::set($this->getPointKey(),$res->award_point + $p);
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        return ['code' => 1,'msg' => '完成'];
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
