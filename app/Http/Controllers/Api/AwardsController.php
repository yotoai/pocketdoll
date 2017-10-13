<?php

namespace App\Http\Controllers\Api;

use App\Model\Awards;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AwardsController extends Controller
{
    // 奖励列表
    public function awards()
    {
        return Awards::all()->toArray();
    }

    // 添加一个奖励
    public function addAwards(Request $request)
    {
        $rules = [
            'contents'    => 'required|max:255',
            'award_coin'  => 'required|integer',
            'award_point' => 'required"integer'
        ];
        $this->validate($request,$rules);
        try{
            $res = Awards::create([
                'contents'    => $request->contents,
                'award_coin'  => $request->award_coin,
                'award_point' => $request->award_poin
            ]);
        }catch (\Exception $e){
            return ['code' => -1,'msg' => $e->getMessage()];
        }
        return $res ? ['code' => 1,'msg' => '添加成功！'] : ['code' => -1,'msg' => '添加失败！'];
    }
}
