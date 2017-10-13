<?php

namespace App\Http\Controllers\Api;

use App\Model\UserShow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserShowController extends BaseController
{
    // 获取玩家秀
    public function userShow()
    {
        return UserShow::all()->toArray();
    }

    // 增加个玩家秀
    public function addUserShow(Request $request)
    {
        $rules = [
            'contents' => 'required|max:500',
        ];
        $this->validate($request,$rules);
        $pic = $this->filesUpload($request);
        try{
            $res = UserShow::create([
                'user_id'  => 2,
                'contents' => $request->contents,
                'pic'      => $pic
            ]);
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        return $res ? ['code' => 1,'msg' => '添加成功！'] : ['code' => -1,'msg' => '添加失败！'];
    }

    // 删除玩家秀
    public function deleteUserShow($id)
    {
        $res = UserShow::where('id',intval($id))->delete();
        return $res ? ['code' => 1,'msg'=>'删除成功！'] : ['code' => -1,'msg' => '删除失败！'];
    }

    // 修改玩家秀状态
    public function updateUserShowStatus($id)
    {
        $status = UserShow::where('id',intval($id))->value('status');
        if(empty($status)) return ['code' => -1,'msg' => '修改失败！'];
        $res = UserShow::where('id',intval($id))->update(['status' => $status == '-1' ? '1' : '-1']);
        return $res ? ['code'=> 1,'msg'=>'修改成功！'] : ['code' => -1,'msg'=>'修改失败！'];
    }
}
