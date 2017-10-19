<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

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
                return $file->store('/images');
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


    /**
     * 获取 redis 中用户的幸运值
     * @param $wid     @娃娃机id
     * @return string
     */
    public function getLuckyRedis($wid)
    {
        $data = Redis::get($this->getOpenid() . '_' . $wid . '_lucky');
        if(empty($data)){
            return 0;
        }else{
            return $data;
        }
    }

    /**
     * 设置 redis 中用户的幸运值
     * @param $wid    @娃娃机id
     * @param $lucky  @增加或者设置 的幸运值
     */
    public function setLuckyRedis($wid,$lucky)
    {
        if($lucky == 0){
            Redis::set($this->getOpenid() .'_'. $wid .'_lucky',$lucky);
        }else{
            Redis::set($this->getOpenid() .'_'. $wid .'_lucky',$this->getLuckyRedis($wid) + $lucky);
        }
    }

     /**
      * 从 redis 获取用户积分
      */
    public function getPointRedis()
    {
        return Redis::get($this->getOpenid().'_point');
    }

    /**
     * 设置积分redis
     * @param $point   @ 添加的积分
     */
    public function setPointRedis($point)
    {
        Redis::set($this->getOpenid().'_point',$point + $this->getPointRedis());
    }

    /**
     * @ 设置任务的redis
     * @param $mid     @任务id
     * @param $status  @任务状态
     */
    public function setMissionRedis($mid,$status)
    {
        Redis::set($this->getOpenid().'_'.$mid.'_mission',$status);
    }

    /**
     * @ 获取任务的redis
     * @param $mid     @任务id
     */
    public function getMissionRedis($mid)
    {
        return Redis::get($this->getOpenid().'_'.$mid.'_mission');
    }




    // 返回成功 或者 失败 状态信息
    public function returnSuccessOrfail($res)
    {
        return $res ? ['code' => 1,'msg' => '添加成功！'] : ['code' => -1,'msg' => '添加失败！'];
    }
}
