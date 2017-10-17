<?php

namespace App\Http\Controllers\Api;

use App\Model\GainLog;
use App\Model\UserRucksack;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserRucksackController extends Controller
{
    // 获取背包列表
    public function rucksack($uid)
    {
        try{
            $data = UserRucksack::join('goods','user_rucksack.goods_id','=','goods.id')
                ->where([
                'user_rucksack.user_id'=>$uid,
                'user_rucksack.status'=>'0'
            ])->get([
                'user_rucksack.id as rucksack_id',
                'user_rucksack.goods_id',
                'user_rucksack.num',
                'goods.name',
                'goods.pic'
            ]);
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        return ['code' => 1,'data' => $data];
    }

    // 提取娃娃   !有问题待解决
    // 每次抓取到娃娃 就添加一条记录
    // 背包中 相同娃娃 通过记录来查询数量，就是页面显示时，娃娃名称 × 数量（如：派大星 × 2）
    // 提现记录 中的 每个娃娃的提现数量 根据 添加记录中 status = 1的 记录计算数量
    public function withdrawDoll(Request $request)
    {
        $rules = [
            'address_id' => 'required|integer',
            'data' => 'required',
            'data.*.rucksack_id' => 'required|integer',
            'data.*.goods_id' => 'required|integer',
            'data.*.num' => 'required|integer',
        ];
        $this->validate($request,$rules);

        try{
            $data = $request->data;
            foreach($data as $key=>$val){
                if(UserRucksack::where('id',$val['rucksack_id'])->value('status') == 1) {
                    return ['code' => -1,'msg' => '该娃娃已提现！'];
                }
            }
            DB::transaction(function () use ($data,$request){
                $rucksack_id = '';
                $count = 0;
                foreach($data as $key=>$val){
                    UserRucksack::where('id',$val['rucksack_id'])->update([
                        'status' => '1',
                        'withdraw_time' => date('Y-m-d H:i:s',time())
                    ]);
                    $rucksack_id .= $val['rucksack_id'] . ',';
                    $count += $val['num'];
                }

                GainLog::create([
                    'user_id'    => $request->user_id,
                    'goods_id'   => trim($rucksack_id,','),
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
