<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RechargeLog extends Model
{
    // 指定表
    protected $table = 'recharge_log';

    // 指定可修改字段
    protected $fillable = ['order','user_id','coin_id','time'];
}
