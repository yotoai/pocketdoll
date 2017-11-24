<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShareData extends Model
{
    // 指定表
    protected $table = 'share_data';

    // 指定字段
    protected $fillable = ['title','desc','links','img_url','status'];
}
