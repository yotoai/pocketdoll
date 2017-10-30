<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;
use Encore\Admin\Grid\Tools\BatchAction;

class ConfirmBox extends AbstractTool
{
    protected $title;
    protected $url;
    protected $ac;
    protected $tb;

    public function __construct($title,$url,$ac,$tb='fa-check')
    {
        $this->title = $title;
        $this->url = $url;
        $this->ac = $ac;
        $this->tb = $tb;
    }

    protected function script()
    {
        return <<<EOT
    $('.upstatus').unbind('click').on('click',function()
    {
         var id = $(this).parents('tr').find('.grid-row-delete').attr('data-id');
         var title = $(this).attr('msg');
         var status = $(this).attr('data-state');
         swal({
                title: title,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确认",
                cancelButtonText: "取消",
                closeOnConfirm: false,
                closeOnCancel: true 
                },
               	function()
               	{
                    $.ajax({
                        type: 'post',
                        url: "{$this->url}",
                        data: {
                            _token:LA.token,
                            id:id,
                            action:status
                        },
                        success: function (data)
                        {
                            $.pjax.reload('#pjax-container');
            
                            if (typeof data === 'object')
                            {
                                if (data.status){
                                    swal(data.message, '', 'success');
                                } else {
                                    swal(data.message, '', 'error');
                                }
                            }
                        }
                    });
                }
        );
    });


EOT;
    }

    public function render()
    {
        Admin::script($this->script());

        return <<<EOT

        <a style="float: left;margin-right: 5px;" class="upstatus" msg="{$this->title}" data-state="{$this->ac}" href="javascript:;"><i class="fa {$this->tb}"></i></a>   
    

EOT;
    }
}