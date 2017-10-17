<?php

namespace App\Http\Controllers\Api;

use App\Model\RechargeAmount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RechargeAmountController extends BaseController
{
    // 获取充值列表
    public function rechargeAmount()
    {
        try{
            $data = RechargeAmount::all();
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        return ['code' => 1,'data' => $data->toArray()];
    }

    // 添加一个充值额度
    public function addRechargeAmount(Request $request)
    {
        $rules = [
            'coin_num'  => 'required|integer',
            'award_num' => 'integer',
            'price'     => 'numeric'
        ];
        $this->validate($request,$rules);
        $pic = $this->filesUpload($request);
        try{
            $res = RechargeAmount::create([
                'coin_num'  => $request->coin_num,
                'award_num' => $request->award_num,
                'price'     => $request->price,
                'pic'       => $pic
            ]);
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        return $res ? ['code' => 1,'msg' => '添加成功！'] : ['code' => -1,'msg' => '添加失败！'];
    }

    // 删除一个
    public function deleteRechargeAmount($id)
    {
        $res = RechargeAmount::where('id',intval($id))->delete();
        return $res ? ['code' => 1,'msg'=>'删除成功！'] : ['code' => -1,'msg' => '删除失败！'];
    }

    // 更新一个
    public function updateRechargeAmont(Request $request,$id)
    {
        $rules = [
            'coin_num'  => 'required|integer',
            'award_num' => 'integer',
            'price'     => 'numeric'
        ];
        $this->validate($request,$rules);
        $pic = $this->filesUpload($request);
        try{
            $res = RechargeAmount::where('id',intval($id))->update([
                'coin_num'  => $request->coin_num,
                'award_num' => $request->award_num,
                'price'     => $request->price,
                'pic'       => $pic
            ]);
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        return $res ? ['code'=> 1,'msg'=>'修改成功！'] : ['code' => -1,'msg'=>'修改失败！'];
    }
}
