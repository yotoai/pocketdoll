<?php

namespace App\Http\Controllers\Api;

use App\Model\Address;
use App\Model\catchLog;
use App\Model\GainLog;
use App\Model\Goods;
use App\Model\UserRucksack;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserRucksackController extends BaseController
{
    // 获取背包列表
    public function rucksack()
    {
        try{
            $data = UserRucksack::join('goods','user_rucksack.goods_id','=','goods.id')
                ->where([
                'user_rucksack.user_id'=>$this->getUserid(),
                'user_rucksack.status'=>'0'
            ])->get([
                'user_rucksack.id as rucksack_id',
                'user_rucksack.goods_id',
                'user_rucksack.num',
                'goods.name',
                'goods.pic'
            ]);
            foreach ($data as $d) {
                $d->pic = env('APP_URL') . '/uploads/'. ($d->pic);
            }
            $list = [];
            foreach ($data as $d){
                $num = $d->num;
                if($num > 1){
                    for($i = 0; $i < $num; $i++) {
                        $list[] = [
                            'rucksack_id' => $d->rucksack_id,
                            'goods_id' => $d->goods_id,
                            'name' => $d->name,
                            'pic' => $d->pic
                        ];
                    }
                }else{
                    $list[] = $d;
                }
            }
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        return ['code' => 1,'msg' => '查询成功','data' => $list];
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
                    if($num - $val['num'] == 0){
                        UserRucksack::where('id',$val['rucksack_id'])->delete();
                    }else{
                        UserRucksack::where('id',$val['rucksack_id'])->update([
                            'num' => $num - $val['num'],
                        ]);
                    }
                    $res_id =  catchLog::where([
                        ['user_id','=',$this->getUserid()],
                        ['goods_id','=',$val['goods_id']],
                        ['status','<>','1']
                    ])->orderBy('id')->take($val['num'])->get(['id'])->pluck('id');
                    catchLog::whereIn('id',$res_id)->update([
                        'status' => '1'
                    ]);
                    $goods_id .= $val['goods_id'] . ',';
                    $count .= $val['num'].',';
                }

                $dz = Address::where('id',$request->address_id)->first();
                $address_info = $dz->name.','.$dz->phone.','.$dz->area_info.','.$dz->address.','.$dz->post_code;
                GainLog::create([
                    'user_id'    => $this->getUserid(),
                    'goods_id'   => rtrim($goods_id,','),
                    'num'        => rtrim($count,','),
                    'address_info' => $address_info
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
        try{
            $res = GainLog::where('user_id',$this->getUserid())->get(['id','goods_id','num','status']);
            $list = [];
            foreach ($res as $key=>$val){
                $gids = explode(',',$val['goods_id']);
                $nums = explode(',',$val['num']);
                $data =  Goods::whereIn('id',$gids)->get(['name','pic']);
                foreach ($data as $k=>$v){
                    $num = $nums[$k];
                    if($num >= 1){
                        for ($i = 0; $i < $num; $i++){
                            $list[] = [
                                'name'   => $v->name,
                                'pic'    => env('APP_URL') . '/uploads/' . $v->pic,
                                'status' => $this->toStatusName($val->status)
                            ];
                        }
                    }
                }
                //$res[$key]['data'] = $data;
            }
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        return ['code' => 1,'msg' => '查询成功','data' => $list];
        // return $res;
    }

    // 转换成状态名称
    private function toStatusName($status)
    {
        if($status == '-1') return '待发货';
        if($status == '1')  return '已发货';
        if($status == '2')  return '已完成';
    }
    
    // 添加收货地址
    public function storeAddress(Request $request)
    {
        $rules = [
            'name'  => 'required|max:255',
            'phone' => 'required|regex:/^1[34578][0-9]{9}$/',
            'area_info' => 'required',
            'address'   => 'required'
        ];
        $this->validate($request,$rules);
        try{
            Address::create([
                'user_id'   => $this->getUserid(),
                'name'      => $request->name,
                'phone'     => $request->phone,
                'area_info' => $request->area,
                'address'   => $request->address
            ]);
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        return ['code' => 1,'msg' => '添加成功！'];
    }
}
