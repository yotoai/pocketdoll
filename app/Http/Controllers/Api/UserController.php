<?php

namespace App\Http\Controllers\Api;

use App\Model\GoodsCategory;
use App\Model\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends BaseController
{
    // 用户授权
    public function oauthUser()
    {
        $user = session('wechat.oauth_user')->toArray(); // 拿到授权用户资料
        $gc = GoodsCategory::orderBy(\DB::raw('RAND()'))->take(1)->get()->toArray()[0];
        $res = $this->addUser($user,$gc['id']);
        if(!$res) return ['code' => -1,'msg' => '获取数据异常...'];
        if($res['code'] == -1) return $res;
        return array_merge(['user'=>$user],['check' => $res],['data'=>$gc]);
    }

    //添加用户
    protected function addUser($user,$gid)
    {
        if(!is_array($user) && empty($user)) return false;
        $key = $this->getRedisKey($gid);
        $data = Users::where('openid',$user['id'])->first();
        if(!empty($data))
        {
            $token = JWTAuth::fromUser($data);
            try{
                $res = Users::where('openid',$user['id'])->update([
                    'login_time' => date('Y-m-d H:i:s',time())
                ]);
            }catch (\Exception $e){
                return ['code' => -1,'msg' => $e->getMessage()];
            }
            if(!$res) return ['code' => -1,'msg' => '用户更新失败！'];
            if(!Redis::exists( $key ))
            {
                Redis::set( $key,0 );
            }
            return ['code' => 1,'token' => $token];
        }
        try{
            $res = Users::create([
                'openid'   => $user['id'],
                'nickname' => $user['nickname'],
                'icon'     => $user['avatar'],
                'coin'     => 0,
                'point'    => 0,
                'login_time' => date('Y-m-d H:i:s',time())
            ]);
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        if(!$res) return ['code' => -1,'msg' => '用户添加失败！'];
        Redis::set( $key,0 );
        return true;
    }
}
