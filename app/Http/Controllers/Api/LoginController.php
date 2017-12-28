<?php

namespace App\Http\Controllers\Api;

use App\Model\Goods;
use App\Model\GoodsCategory;
use App\Model\InviteLog;
use App\Model\Mission;
use App\Model\Player;
use App\Model\Users;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends BaseController
{
    // 用户授权 (跳转登录)
    public function login(Request $request)
    {
        $this->validate($request,[
            'sdkId'  => 'required',
            'userId' => 'required',
            'timestamp' => 'required',
           // 'sign'   => 'required'
        ]);

//        if($request->sign != strtolower( md5($request->sdkId.$request->userId.$request->userName.$request->userImg.$request->timestamp.env('GAMEKEY')))){
//            return ['code' => -1,'msg' => '验证失败'];
//        }
        $this->setUserId($request->userId);
        $res = $this->addUser($request);
//        return $res;
        if(!$res){
            return ['code' => -1,'msg' => '获取数据异常...'];
        }
        if($res['code'] == -1){
            return $res;
        }
//        Redis::set($this->getUserid().'_shareWithWx',0); // 分享次数 初始化
//        $this->setUserId($request->userId);
        $goods_id = Goods::where('status','<>','-1')->distinct()->get(['goods_cate_id'])->pluck('goods_cate_id');
        $cid = GoodsCategory::whereIn('id',$goods_id)->where('status','<>','-1')->get(['id'])->pluck('id')->toArray();
        $data = $this->selectDollMachine($cid[array_rand($cid)]);
        return array_merge($res,['data' => $data]);
    }

    // 账号登录
    public function index(Request $request)
    {
        $this->validate($request,[
            'username' => 'required',
            'password' => 'required'
        ]);

        try{
            $user = Users::where('phone',$request->username)->first();
            if(empty($user)){
                return ['code' => -1,'msg' => '账号或者密码错误'];
            } elseif(!(new BcryptHasher())->check($request->password,$user->password)){
                return ['code' => -1,'msg' => '账号或者密码错误！'];
            }else{
                if(date('Y-m-d') != date('Y-m-d',$user->login_time)){
                    $day = $user->login_day + 1;
                }else{
                    $day = $user->login_day;
                }
                Users::where('phone',$request->username)
                    ->update([
                        'login_day' => $day,
                        'login_time' => date('Y-m-d H:i:s',time())
                    ]);
            }

            $token = JWTAuth::fromUser(Users::where('phone',$request->username)->first());
            $user = [
                'username' => $user->phone,
                'icon'     => $user->icon,
                'coin'     => $user->coin,
                'token'    => $token
            ];
            $this->setUserId($request->userId);
            $goods_id = Goods::where('status','<>','-1')->distinct()->get(['goods_cate_id'])->pluck('goods_cate_id');
            $cid = GoodsCategory::whereIn('id',$goods_id)->where('status','<>','-1')->get(['id'])->pluck('id')->toArray();
            $data = $this->selectDollMachine($cid[array_rand($cid)]);
            return array_merge($user,['data' => $data]);
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
    }

    //添加用户
    protected function addUser($request)
    {
        if( empty($request) ) return false;
        $data = Player::where('user_id',$request->userId)->first();
        if(!empty($data))
        {
            try{
                if(strtotime($data->login_time) > strtotime(date('Y-m-d 00:00:00'))){
                    $day = $data->login_day;
                }else{
                    $day = $data->login_day + 1;
                }
                Player::where('user_id',$request->userId)->update([
                    'sdk_id'     => $request->sdkId,
                    'user_name'  => empty($request->userName) ? '' : $request->userName,
                    'user_img'   => empty($request->userImg) ? '' : $request->userImg,
                    'login_day'  => $day,
                    'login_time' => date('Y-m-d H:i:s',time())
                ]);
                $User = Player::where('user_id',$request->userId)->first();
                $token = JWTAuth::fromUser($User);
                $user = [
                    'username' => $data->user_name,
                    'icon'     => $data->user_img,
                    'coin'     => $data->coin
                ];
                if($User->new_user_mission == '-1'){
                    $datas = $this->getLoginMission();
                    $list = [];
                    foreach ($datas as $ds){
                        $list[] = unserialize($ds);
                    }
//                    return $list;
                    sort($list);
                    $dayss = Mission::where('type',4)
                        ->orderBy('need_num','asc')
                        ->get(['id','need_num','status'])
                        ->toArray();
//                    return $day;
                    foreach ($dayss as $key=>$val){
                        foreach ($list as $k=>$v){
                            if($val['need_num'] == $v['need_num']){
                                $dayss[$key]['id'] = $val['id'];
                                $dayss[$key]['status'] = $v['status'];
                            }
                        }
                    }

                    $c = count($dayss);
                    Redis::del($request->userId.'_login_missions');
                    $isdraw = Redis::get($this->getUserid().'_isdraw');
                    for ($i = $c - 1;$i > 0;$i--){
                        for($j = 0;$j <  $i;$j++){
                            if($dayss[$j]['status'] == '2' && $dayss[$j+1]['status'] != '2' && $day >= $dayss[$j+1]['need_num'] && intval($isdraw) != 1){
                                $dayss[$j+1]['status'] ='1';
                            }
                        }
                    }
                    foreach ($dayss as $da){
                        Redis::sadd($request->userId.'_login_missions',serialize($da) );
                    }
                }
            }catch (\Exception $e){
                return ['code' => -1,'msg' => $e->getMessage()];
            }
            return ['code' => 1,'token' => $token,'user' => $user];
        }else{
            try{
//                DB::transaction(function () use ($request){
                    $data = Player::create([
                        'sdk_id'    => $request->sdkId,
                        'user_id'   => $request->userId,
                        'user_name' => $request->userName,
                        'user_img'  => $request->userImg,
                        'parent_id' => empty($request->parent_id) ? 0 : $request->parent_id,
                        'coin'      => 0,
                        'login_day' => 1,
                        'login_time' => date('Y-m-d H:i:s',time())
                    ]);
//                    InviteLog::create([
//                        'inviter_id'   => $request->parent_id,
//                        'invitered_id' => $request->userId,
//                        'level' => $this->getParent($request->parent_id)
//                    ]);
//                },5);


                $token = JWTAuth::fromUser(Player::where('user_id',$request->userId)->first());
                $user = [
                    'username' => $data->user_name,
                    'icon'     => $data->user_img,
                    'coin'     => $data->coin
                ];
                $day = Mission::where('type',4)
                    ->orderBy('id','asc')->get(['id','need_num','status'])->toArray();
                foreach ($day as $da){
                    if($da['need_num'] == 1){
                        $da['status'] = '1';
                    }
                    Redis::sadd($request->userId.'_login_missions',serialize($da) );
                }
            }catch (\Exception $e){
                return ['code' => -1,'msg' => $e->getMessage(),$e->getLine()];
            }
            return ['code' => 1,'token' => $token,'user' => $user];
        }
    }

    // 娃娃机选择 // 需开启redis
    public function selectDollMachine($id)
    {
        try{
            $lucky = $this->getLuckyRedis($id);
            if(intval($lucky) <= 0 )
            {
                $this->setLuckyRedis($id,0);
                $lucky = $this->getLuckyRedis($id);
            }
            $data = Goods::where('goods_cate_id',intval($id))->where('status','<>','-1')->get([
                'id',
                'goods_cate_id',
                'name',
                'add_num',
                'pic',
                'sc_pic',
                'width',
                'height',
                'xdheight'
            ]);
            if(empty($data->toArray())) return ['code' => -1,'msg' => '该娃娃机没有放入娃娃...'];
            $list = [];
            foreach ($data as $d) {
                for ($i = $d->add_num;$i > 0 ;$i-- ){
                    $list[] = [
                        'id' => $d->id,
                        'goods_cate_id' => $d->goods_cate_id,
                        'name' => $d->name,
                        'pic' => env('APP_URL').'/uploads/'.$d->pic,
                        'sc_pic' => env('APP_URL').'/uploads/'.$d->sc_pic,
                        'width' => $d->width,
                        'height' => $d->height,
                        'xdheight' => $d->xdheight
                    ];
                }
            }
            $coin = GoodsCategory::where('id',$id)->value('coin');
            return ['code' => 1,'coin' => $coin,'lucky' => $lucky,'data' => $list];
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
    }

    // 刷新 token
    public function refreshToken()
    {
        $old_token = JWTAuth::getToken();
        $token = JWTAuth::refresh($old_token);
        JWTAuth::invalidate($old_token);
        return $token;
    }

    // 查询上级
    protected function getParent($parent_id,$level=1)
    {
        $pdata = Player::find($parent_id);
        if(!empty($pdata->parent_id)) {
            $this->getParent($pdata,++$level);
        }else{
            return $level;
        }
    }
}
