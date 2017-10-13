<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    // 指定表
    protected $table = 'mission';

    // 指定字段
    protected $fillable = ['contents','award_id','type','need_num','status','icon'];


    // 关联 任务系列 表
    public function Awards()
    {
        return $this->hasOne('App\Model\Awards','id','award_id');
    }
}
