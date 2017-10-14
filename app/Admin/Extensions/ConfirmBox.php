<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;
use Encore\Admin\Grid\Tools\BatchAction;

class ConfirmBox extends AbstractTool
{
    protected $action;
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function script()
    {
        return <<<EOT
    $('.upstatus').unbind('click').on('click',function()
    {
         var id = $(this).data('id');
         console.log(id + '11');
         swal({
                title: "确认通过？",
                text:{$this->id},
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
                        url: 'usershow/updateStatus',
                        data: {
                            _token:LA.token,
                            id:$this->id,
                            action:1
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

        <a style="float: left" class="upstatus" href="javascript:;"><i class="fa fa-check"></i></a>    
    

EOT;
    }
}