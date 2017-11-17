<?php

namespace App\Http\Controllers\Api;

use App\Model\Goods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Tymon\JWTAuth\Facades\JWTAuth;

class BaseController extends Controller
{
    //
    protected $uid;
    public function __construct()
    {

    }

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
        if(empty(JWTAuth::getToken())){
            return $this->getUid();
        }else{
            $user = JWTAuth::parseToken()->authenticate();
            return $user->user_id;
        }
       // return session('wechat.oauth_user')->toArray()['id'];
    }

    public function getUser()
    {
        if(empty(JWTAuth::getToken())){
            return $this->getUid();
        }else{
            $user = JWTAuth::parseToken()->authenticate();
            return $user;
        }
    }

    public function getUserid()
    {
        if(empty(JWTAuth::getToken())){
            return $this->getUid();
        }else{
            $user = JWTAuth::parseToken()->authenticate();
            return $user->user_id;
        }
    }


    public function setUserId($user_id)
    {
        $this->uid = $user_id;
    }

    public function getUid()
    {
        return $this->uid;
    }
    /**
     * 获取 redis 中用户的幸运值
     * @param $wid     @娃娃机id
     * @return string
     */
    public function getLuckyRedis($wid)
    {
        $data = Redis::get($this->getUserid() . '_' . $wid . '_lucky');
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
            Redis::set($this->getOpenid() .'_'. $wid .'_lucky',$lucky + $this->getLuckyRedis($wid) );
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

    // 设置抓取次数
    public function setCatchNum($num=0)
    {
        if($num == 0){
            Redis::set($this->getOpenid().'_catch', $num);
        }else{
            Redis::set($this->getOpenid().'_catch',$this->getCatchNum() + $num);
        }
    }

    // 获取用户的抓取次数
    public function getCatchNum()
    {
        return Redis::get($this->getOpenid().'_catch');
    }

    // 设置 抓到娃娃次数
    public function setCatchedNum($num=0)
    {
        if($num == 0){
            Redis::set($this->getOpenid().'_catched',$num);
        }else{
            Redis::set($this->getOpenid() .'_catched',$this->getCatchedNum() + $num);
        }
    }

    // 获取用户抓到娃娃的次数
    public function getCatchedNum()
    {
        return Redis::get($this->getOpenid().'_catched');
    }

    // 设置 充值次数
    public function setChargeNum($num=0)
    {
        Redis::set($this->getOpenid().'_charge',$this->getChargeNum() + $num);
    }

    // 获取 充值次数
    public function getChargeNum()
    {
        return Redis::get($this->getOpenid().'_charge');
    }

    // 模糊获取 Redis 的key
    public function getKeys($type)
    {
        return Redis::keys($this->getOpenid().'_*_'.$type);
    }

    // 获取对应key的值
    public function getValues($key)
    {
        return Redis::get($key);
    }

    // 获取对应key的值
    public function getVal($key)
    {
        return Redis::get($this->getOpenid().'_'.$key.'_mission');
    }

    // 返回成功 或者 失败 状态信息
    public function returnSuccessOrfail($res)
    {
        return $res ? ['code' => 1,'msg' => '添加成功！'] : ['code' => -1,'msg' => '添加失败！'];
    }

    // 生成海报二维码
    public function getQrCode()
    {
        if(!file_exists(public_path('qrcode'))){
            mkdir(public_path('qrcode'));
        }
        $uid = $this->getUserid();
        $filename = md5('baby'.$uid);
        if(file_exists(public_path('baby'.$uid.'.png'))){
            return env('APP_URL').'/qrcode/'.$filename.'.png';
        }
        $url = 'http://114.215.106.114:8081/sdk_new/tdpay/gameLogin.do?sdkId=2098&sign=e4d2be517a26de831f024c5bdbd307ab&loginType=mplogin&uid='.$uid;
        QrCode::format('png')->size(200)->generate($url,public_path('qrcode/'.$filename.'.png'));
        return env('APP_URL').'/qrcode/'.$filename.'.png';
    }
    
    // 返回 虚拟抓取到的 信息
    public function getfakename()
    {
        $data = trim(substr(file_get_contents(storage_path("app/name/nickname.php")),15));
        $data = explode('&',$data);
        $nickname = $data[array_rand($data,1)];
        $goods_name = Goods::orderBy(DB::raw('RAND()'))->where('status','<>','-1')->take(1)->value('name');
        return ['code' => 1,'msg' => '查询成功','nickname' => $nickname,'goods_name' => $goods_name];
    }

    // 弹幕
    public function getBarrage($cid)
    {
        $data = trim(substr(file_get_contents(storage_path("app/name/nickname.php")),15));
        $data = explode('&',$data);
        $nickname = $data[array_rand($data,1)];
        $goods_name = Goods::where('goods_cate_id',$cid)->where('status','<>','-1')->get(['name'])->pluck('name')->toArray();
        $goods_name = $goods_name[array_rand($goods_name,1)];
        $barrage = $nickname.'抓了一次'.$goods_name.$this->randWord();
        return ['code' => 1,'msg' => '查询成功','barrage' => $barrage];
    }
    // 随机返回一句话
    protected function randWord()
    {
        $word = [
            '没抓到，赶紧去捡漏！',
            '没抓到，下一次是填坑还是捡漏呢？',
            '没抓到，这台机器离大力一抓又近了一步！',
            '没抓到，填了一次坑！'
        ];
        return $word[array_rand($word,1)];
    }
}
