<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GoodsCategory extends Model
{
    // 指定表
    protected $table = 'goods_category';

    // 指定可修改类型
    protected $fillable = ['cate_name','win_rate','pic','doll_talk','small_expression','tag_id','spec','coin'];
}
