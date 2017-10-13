<?php

namespace App\Http\Controllers\Api;

use App\Model\Goods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends BaseController
{
    // 获取娃娃列表
    public function goods()
    {
        return Goods::all()->toArray();
    }

    // 添加一个娃娃
    public function addGoods(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'goods_cate_id' => 'required|integer|max:10'
        ];
        $this->validate($request,$rules);
        $pic = $this->filesUpload($request);
        try{
            $res = Goods::create([
                'name' => $request->name,
                'pic'  => $pic,
                'coin' => 10,
                'spec' => 5,
                'tag_id' => 3,
                'goods_cate_id' => $request->goods_cate_id
            ]);
        }catch (\Exception $e){
            return ['code' => -1,'msg'=>$e -> getMessage()];
        }
        return $res ? ['code' => 1,'msg' => '添加成功！'] : ['code' => -1,'msg' => '添加失败！'];
    }

    // 删除一个娃娃
    public function deleteGoods($id)
    {
        $res = Goods::where('id',intval($id))->update(['status' => '-1']);
        return $res ? ['code' => 1,'msg' => '删除成功！'] : [' code' => -1,'msg' => '删除失败！'];
    }

    // 修改一个娃娃
    public function updateGoods(Request $request,$id)
    {
        $rules = [
            'name' => 'required|max:255',
            'goods_cate_id' => 'required|integer|max:10'
        ];
        $this->validate($request,$rules);
        $goods = Goods::find(intval($id));
        if(empty($goods)) return ['code' => -1,'msg' => '未知商品！'];
        $pic = $this->filesUpload($request);
        try{
            $res = Goods::where('id',intval($id))->update([
                'name' => $request->name,
                'pic'  => $pic,
                'coin' => 10,
                'spec' => 5,
                'tag_id' => 3,
                'goods_cate_id' => $request->goods_cate_id
            ]);
        }catch (\Exception $e){
            return ['code' => $e->getCode(),'msg' => $e->getMessage()];
        }
        return $res ? ['code'=> 1,'msg'=>'修改成功！'] : ['code' => -1,'msg'=>'修改失败！'];
    }
}

