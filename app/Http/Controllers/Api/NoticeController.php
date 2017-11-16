<?php

namespace App\Http\Controllers\Api;

use App\Model\HelpCenter;
use App\Model\Notice;
use Dingo\Api\Http\Request;

class NoticeController extends BaseController
{
    // 前台获取公告列表
    public function qnotice()
    {
        try{
            $list = Notice::where('status','<>','-1')
                ->orderBy('id','desc')
                ->get([
                    'id',
                    'title',
                    'contents',
                    'pic'
                ]);
            foreach ($list as $notic){
                if(!empty($notic->pic)){
                    $notic->pic = env('APP_URL').'/uploads/'. ($notic->pic);
                }
            }
        }catch (\Exception $e){
            return ['code' =>-1,'msg' => $e->getMessage()];
        }
        return ['code' => 1,'msg' => '查询成功','data' => $list];
    }


    // 返回帮助中心
    public function helpinfo()
    {
        return HelpCenter::all();
    }
}
