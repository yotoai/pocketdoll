<?php

namespace App\Admin\Controllers;

use App\Model\Player;
use App\Model\RechargeAmount;
use App\Model\RechargeLog;

use App\Model\Users;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class RechargeLogController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('充值记录');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(RechargeLog::class, function (Grid $grid) {

//            $grid->actions(function ($actions) {
//                $actions->disableDelete();
//                $actions->disableEdit();
//            });
            $grid->disableActions();
            $grid->disableCreation();

            $grid->id('ID')->sortable();
            $grid->user_id('用户名')->display(function ($uid){
               return Player::where('user_id',$uid)->first()->user_name;
            });
            $grid->order('订单号');
            $grid->pay('支付金额');
            $grid->coin('充值数量')->display(function ($coin){
               //$res = RechargeAmount::find($aid);
               //return $res->coin_num . ' ' . ($res->award_num ? '(奖励 '. $res->award_num .')' : '');
                return '充值'.$coin .'金币';
            });
            $grid->status('充值状态')->display(function ($status){
               return $status == 1 ? "<span class='label label-success'>支付成功</span>" : ($status == -1 ? "<span class='label label-default'>未支付</span>" : "<span class='label label-danger'>充值失败</span>");
            });
            $grid->status_des('状态描述');

            $grid->column('time','充值时间');

            $grid->created_at('创建时间');
            //$grid->updated_at('更新时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(RechargeLog::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
