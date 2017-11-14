<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserVerifyCode extends Model
{
    // 指定表
    protected $table = 'user_verifycode';

    // 指定字段
    protected $fillable = ['phone','verifycode'];
}
