<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserRucksack extends Model
{
    //指定表
    protected $table = 'user_rucksack';
    //指定可修改字段
    protected  $fillable = ['user_id','goods_id','status','withdraw_time','gain_time'];

    // 关联 商品娃娃 数据表
    public function Goods()
    {
        return $this->hasOne('App\Model\Goods','id','goods_id');
    }
}
