<?php

namespace App\Http\Controllers\Api;

use App\Model\Mission;
use App\Model\missionType;
use Illuminate\Http\Request;

class MissionController extends BaseController
{
    //登录任务
    public function loginInMission()
    {

    }

    // 每日任务
    public function dayMission()
    {
        $tid = missionType::get(['id']);
        foreach($tid as $v){
            $list[] = Mission::with('Awards')->where('type',$v['id'])->orderBy('id')->get();
        }
        return $list;
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
