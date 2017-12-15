<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PointLog extends Model
{
    // 指定表
    protected $table = 'point_log';

    // 指定字段
    protected $fillable = ['sdk_id','user_id','user_name','point_num','get_way'];
}
