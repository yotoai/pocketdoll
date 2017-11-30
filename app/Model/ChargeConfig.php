<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChargeConfig extends Model
{
    // 指定表
    protected $table = 'charge_config';

    // 指定字段
    protected $fillable = ['identity','name','rebate_ratio'];
}
