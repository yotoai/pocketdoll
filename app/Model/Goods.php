<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    //
    protected $table = 'goods';

    protected $fillable = [
        'name','goods_cate_id','add_num','pic','sc_pic','bq_pic','width','height','status'
    ];
}
