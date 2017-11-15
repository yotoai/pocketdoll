<?php

namespace App\Http\Controllers\Api;

use App\Model\Player;
use App\Model\UserVerifyCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    // 注册
    public function addUser(Request $request)
    {
        $this->validate($request,[
            'phone' => 'required|regex:/^1[34578][0-9]{9}$/|unique:player',
            'verifycode' => 'required|max:6',
            'password' => 'required|max:36',
            'captcha' => 'required|captcha'
        ]);
        try{
            $data = UserVerifyCode::where('phone',$request->phone)
                ->where('verifycode',$request->verifycode)
                ->first();
            if($data->verfiycode != $request->verfiycode || empty($data)){
                return ['code' => -1,'msg' => '手机验证错误'];
            }
            $res = Player::create([
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
            ]);
            if($res){
                return ['code' => 1,'msg' => '注册成功'];
            }else{
                return ['code' => -1,'msg' => '注册失败'];
            }
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
    }

    // 返回验证码
    public function verifyCode()
    {
        return captcha_src();
    }

    // 发送短信
    public function sendCode(Request $request)
    {
        $this->validate($request,[
            'phone'   => 'required|regex:/^1[34578][0-9]{9}$/|unique:player',
        ]);
        // 生成手机验证吗
        $code = "";
        for($i = 0; $i < 6;$i++){
            $code .= rand(0,9);
        }
        try{
            UserVerifyCode::create([
                'phone' => $request->phone,
                'verifycode' => $code
            ]);
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }

    }
}
