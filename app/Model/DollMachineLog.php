<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DollMachineLog extends Model
{
    // 指定表
    protected $table = 'doll_machine_log';

    // 指定字段
    protected $fillable = ['sdk_id','doll_machine_id','doll_machine_name','catch_num','catched_num','lucky_model_catch_num'];
}
