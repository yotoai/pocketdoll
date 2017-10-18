<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    //
    public function filesUpload(Request $request)
    {
        $pic = '';
        if($request->hasFile('pic'))
        {
            if ($request->file('pic')->isValid()){
                $file = $request->file('pic');
                return storage_path( $file->store('/image'));
            }else{
                return ['code'=>-1,'msg'=>'图片上传失败'];
            }
        }else{
            return $pic;
        }
    }

    // 获取openid // 拿到授权用户资料
    public function getOpenid()
    {
        return session('wechat.oauth_user')->toArray()['id'];
    }

    // 返回 redis 的键
    public function getRedisKey($id)
    {
        return $this->getOpenid() . '_' . $id . '_lucky';
    }

    // 返回积分key
    public function getPointKey()
    {
        return $this->getOpenid() . '_point';
    }

    // 返回成功 或者 失败 状态信息
    public function returnSuccessOrfail($res)
    {
        return $res ? ['code' => 1,'msg' => '添加成功！'] : ['code' => -1,'msg' => '添加失败！'];
    }
}
