<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;
use Encore\Admin\Grid\Tools\BatchAction;

class InputBox extends AbstractTool
{
    protected $title;
    protected $url;
    protected $ac;
    protected $tb;
    protected $style;

    public function __construct($title,$url,$ac,$tb='fa-check',$style='float: left;')
    {
        $this->title = $title;
        $this->url = $url;
        $this->ac = $ac;
        $this->tb = $tb;
        $this->style = $style;
    }

    protected function script()
    {
        return <<<EOT
    $('.upstatus').unbind('click').on('click',function()
    {
         var id = $(this).parents('tr').find('.grid-row-checkbox').attr('data-id');
         var title = $(this).attr('msg');
         var status = $(this).attr('data-state');
         swal({ 
              title: title, 
              text: "请输入快递单号",
              type: "input", 
              showCancelButton: true, 
              closeOnConfirm: false, 
              confirmButtonText: "确认",
              cancelButtonText: "取消",
              animation: "slide-from-top"
            },
            function(inputValue){ 
                if (inputValue === false) return false; 
              
                if (inputValue === "") { 
                    swal.showInputError("你需要输入快递单号！");
                    return false 
                } 
              
                    $.ajax({
                        type: 'post',
                        url: "{$this->url}",
                        data: {
                            _token:LA.token,
                            id:id,
                            track:inputValue,
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
            });
    });

EOT;
    }

    public function render()
    {
        Admin::script($this->script());

        return <<<EOT

        <a style="{$this->style}margin-right: 5px;" class="upstatus" msg="{$this->title}" data-state="{$this->ac}" href="javascript:;"><i class="fa {$this->tb}"></i></a>   
    

EOT;
    }
}