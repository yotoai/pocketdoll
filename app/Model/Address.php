<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    // 指定表
    protected $table = 'address';

    // 指定字段
    protected $fillable = ['name','phone','area_info','address','post_code'];
}
