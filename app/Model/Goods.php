<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    //
    protected $fillable = ['name','goods_cate_id','pic','coin','spec','tag_id','addtime'];
}
