<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class catchLog extends Model
{
    // 指定表
    protected $table = 'catchdoll_log';

    // 指定字段
    protected $fillable = ['user_id','goods_id','status'];
}
