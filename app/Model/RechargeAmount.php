<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RechargeAmount extends Model
{
    //指定表
    protected $table = 'recharge_amount';

    // 制定可修改的字段
    protected $fillable = ['coin_num','award_num','price','pic'];
}
