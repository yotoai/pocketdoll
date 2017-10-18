<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GainLog extends Model
{
    // 指定表
    protected $table = 'gain_log';

    // 指定字段
    protected $fillable = ['user_id','goods_id','num','status','address_id'];
}
