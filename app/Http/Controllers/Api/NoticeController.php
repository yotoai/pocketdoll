<?php

namespace App\Http\Controllers\Api;

use App\Model\Notice;
use Dingo\Api\Http\Request;

class NoticeController extends BaseController
{
    // 前台获取公告列表
    public function qnotice(Request $request)
    {
        return $request;
        try{
            $list = Notice::where('status','<>','-1')->get();
            foreach ($list as $notic){
                $notic->pic = public_path($notic->pic);
            }
        }catch (\Exception $e){
            return ['code' =>-1,'msg' => $e->getMessage()];
        }
        return ['code' => 1,'msg' => '查询成功','data' => $list];
    }




    // 后台获取公告列表
    public function hnotice()
    {
        return Notice::all()->toArray();
    }

    // 添加公告
    public function addNotice(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'contents' => 'required|max:255'
        ];
        $this->validate($request,$rules);
        $pic = $this->filesUpload($request);
        try {
            $res = Notice::create([
                    'title'   => $request->title,
                    'content' => $request->contents,
                    'pic'     => $pic
                 ]);
        }catch (\Exception $e){
            return ['code' => -1,'msg'=>$e->getMessage()];
        }
        return $res ? ['code' => 1,'msg' => '添加成功！'] : ['code' => -1,'msg' => '添加失败！'];
    }

    // 删除公告
    public function deleteNotice($id)
    {
        $res = Notice::where('id',intval($id))->delete();
        return $res ? ['code' => 1,'msg' => '删除成功！'] : ['code' => -1,'msg'=> '删除失败！'];
    }

    // 更改公告
    public function updateNotice(Request $request,$id)
    {
        $notice = Notice::find(intval($id));
        if(empty($notice)) return ['code' => -1,'msg' => '未知公告！'];
        if($request->hasFile('pic'))
        {
            if ($request->file('pic')->isValid()){
                $file = $request->file('pic');
                $pic = $file->store('/image');
                $notice->pic = storage_path($pic);
            }else{
                return ['code'=>-1,'msg'=>'图片上传失败'];
            }
        }
        $notice->title = $request->title;
        $notice->content = $request->contents;
        return $notice->save() ? ['code'=> 1,'msg'=>'修改成功！'] : ['code' => -1,'msg'=>'修改失败！'];
    }

    // 更改公告状态
    public function updateNoticeStatus($id)
    {
        $res = Notice::where('id',intval($id))->value('status');
        if(empty($res)) return ['code' => -1,'msg'=>'修改失败！'];
        $res = Notice::where('id',intval($id))->update(['status' => $res == '-1' ? '1' : '-1']);
        return $res ? ['code'=> 1,'msg'=>'修改成功！'] : ['code' => -1,'msg'=>'修改失败！'];
    }
}
