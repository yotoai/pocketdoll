<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Awards extends Model
{
    // 指定表
    protected $table = 'awards';

    // 指定字段
    protected $fillable = ['contents','award_coin','award_point'];
}
