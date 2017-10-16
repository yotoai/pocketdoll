<?php

namespace App\Http\Controllers\Api;

use App\Model\GainLog;
use App\Model\UserRucksack;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserRucksackController extends Controller
{
    // 获取背包列表
    public function rucksack($uid)
    {
        return UserRucksack::where('user_id',$uid)->get();
    }

    // 提取娃娃
    public function withdrawDoll(Request $request)
    {
        $rules = [
            'num' => 'required|integer',
            'goods_id' => 'required'
        ];
        $this->validate($request,$rules);
        try{
            $ids = explode(',',$request->goods_id);
            foreach($ids as $id){
                if(UserRucksack::where('id',$id)->value('status') == 1) {
                    return ['code' => -1,'msg' => '该娃娃已提现！'];
                }
            }
            DB::transaction(function () use ($id,$request){
                UserRucksack::where('id',$id)->update([
                    'status' => '1',
                    'withdraw_time' => date('Y-m-d H:i:s',time())
                ]);

                GainLog::create([
                    'user_id'    => $request->user_id,
                    'goods_id'   => $request->goods_id,
                    'num'        => $request->num,
                    'address_id' => $request->address_id
                ]);
            },3);

        }catch (\Exception $e){
            return ['code' => -1,'msg' => '提现异常...'];
        }
        return ['code' => 1,'msg' => '提现成功！'];
    }

    // 提取记录
    public function withdrawLog($id)
    {
        return UserRucksack::where('status','1')->where('user_id',$id)->get();
    }
}
