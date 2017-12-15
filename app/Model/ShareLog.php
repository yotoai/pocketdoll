<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShareLog extends Model
{
    // 指定表
    protected $table = 'share_log';

    // 指定字段
    protected $fillable = ['sdk_id','user_id','user_name','share_num','share_type'];
}
