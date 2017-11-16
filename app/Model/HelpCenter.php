<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class HelpCenter extends Model
{
    // 指定表
    protected $table = 'help_center';

    // 指定字段
    protected $fillable = ['problem','answer'];
}
