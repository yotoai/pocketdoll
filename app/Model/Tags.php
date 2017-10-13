<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    // 指定表
    protected $table = 'goods_tags_cate';

    // 指定指定
    protected $fillable = ['tag_icon','tag_name'];
}
