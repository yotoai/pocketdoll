<?php

namespace App\Model;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use ModelTree, AdminBuilder;
    // 指定表
    protected $table = 'mission';

    // 指定字段
    protected $fillable = ['title','award_id','parent_id','sort','type','need_num','status','icon'];

    public function __construct(array $attributes  = [])
    {
        parent::__construct($attributes);

        $this->setOrderColumn('sort');
    }

    // 关联 任务系列 表
    public function Awards()
    {
        return $this->hasOne('App\Model\Awards','id','award_id');
    }
}
