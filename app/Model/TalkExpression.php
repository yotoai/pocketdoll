<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TalkExpression extends Model
{
    // 指定表
    protected $table = 'talk_expression';

    // 指定字段
    protected $fillable = ['talk_doll','dollmachine_id','small_expression','type'];

    public function setSmallExpressionAttribute($pictures)
    {
        if (is_array($pictures)) {
            $this->attributes['small_expression'] = "'".json_encode($pictures)."'";
        }
    }

    public function getSmallExpressionAttribute($pictures)
    {
        return json_decode(trim($pictures,"'"),true);
    }
}
