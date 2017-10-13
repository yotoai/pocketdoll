<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    // 指定表
    protected $table = 'notice';
    // 允许修改字段
    protected $fillable = ['title','content','pic'];
    // 获取公告
    public function noticeList()
    {
        //
        return $this->where('status','<>','-1')->get();
    }
}
