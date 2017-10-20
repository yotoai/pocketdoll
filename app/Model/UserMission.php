<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserMission extends Model
{
    // 指定表
    protected $table = 'user_mission';

    // 指定字段
    protected $fillable = ['user_id','mission_id','status'];
}
