<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CoinLog extends Model
{
    // 指定表
    protected $table = 'coin_log';

    // 指定字段
    protected $fillable = ['user_id','user_name','sender_id','sender','send_contents','status'];
}
