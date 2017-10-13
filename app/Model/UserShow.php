<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserShow extends Model
{
    //指定表
    protected $table = 'user_show';

    // 指定可修改字段
    protected $fillable = ['user_id','contents','pic','status'];
}
