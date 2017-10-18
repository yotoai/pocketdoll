<?php

namespace App\Http\Controllers\Api;

use App\Model\catchLog;
use App\Model\GainLog;
use App\Model\Goods;
use App\Model\UserRucksack;
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
            foreach($data as $key=>$val) {
                $num = UserRucksack::where('id', $val['rucksack_id'])->value('num');
                if ($num < $val['num']) return ['code' => -1, 'msg' => '娃娃数量不足！'];
            }
            DB::transaction(function () use ($data,$request){
                $goods_id = '';
                $count = '';
                foreach($data as $key=>$val) {
                    $num = UserRucksack::where('id', $val['rucksack_id'])->value('num');
                    UserRucksack::where('id',$val['rucksack_id'])->update([
                        'num' => $num - $val['num'],
                    ]);
                    $res_id =  catchLog::where([
                        ['user_id','=',2],
                        ['goods_id','=',$val['goods_id']],
                        ['status','<>','1']
                    ])->orderBy('id')->take($val['num'])->get(['id'])->pluck('id');
                    catchLog::whereIn('id',$res_id)->update([
                        'status' => '1'
                    ]);
                    $goods_id .= $val['goods_id'] . ',';
                    $count .= $val['num'].',';
                }
                GainLog::create([
                    'user_id'    => 2,
                    'goods_id'   => rtrim($goods_id,','),
                    'num'        => rtrim($count,','),
                    'address_id' => $request->address_id
                ]);
            },3);

        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        return ['code' => 1,'msg' => '提现成功！'];
    }

    // 提取记录
    public function withdrawLog()
    {
        $res = GainLog::where('user_id',2)->get(['id','goods_id','num','status']);
        foreach ($res as $key=>$val){
            $data = [];
            $gids = explode(',',$val['goods_id']);
            $nums = explode(',',$val['num']);
            foreach (Goods::whereIn('id',$gids)->get(['name','pic']) as $k=>$v){
                $data[$k] = $v;
                $data[$k]['num'] = $nums[$k];
            }
            $res[$key]['data'] = $data;
        }
        return $res;
    }
}
