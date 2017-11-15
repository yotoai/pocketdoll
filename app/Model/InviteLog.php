<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InviteLog extends Model
{
    // 指定表
    protected $table = 'invite_log';

    // 指定字段
    protected $fillable = ['inviter_id','invitered_id'];
}
