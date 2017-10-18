<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SignIn extends Model
{
    // 指定表
    protected $table = 'signin';

    // 指定字段
    protected $fillable = ['user_id','sign_time','sign_day_num'];
}
