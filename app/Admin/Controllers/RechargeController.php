<?php

namespace App\Admin\Controllers;

use App\Model\RechargeAmount;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class RechargeController extends Controller
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

            $content->header('充值管理');
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

            $content->header('编辑充值');
            $content->description('编辑');

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

            $content->header('创建充值');
            $content->description('创建');

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
        return Admin::grid(RechargeAmount::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->column('title','充值名称');
            $grid->coin_num('充值金币数量');
            $grid->award_num('奖励金币数量');
            $grid->price('价格');
            $grid->pic('图标')->image('/uploads/',36,36);

            $grid->created_at('创建时间');
            $grid->updated_at('修改时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(RechargeAmount::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('title','充值名称：')->rules('required|max:255');
            $form->number('coin_num','充值数量：')->rules('required|integer');
            $form->number('award_num','奖励数量：')->rules('integer');
            $form->text('price','价格：')->rules('required|numeric');
            $form->image('pic','图标：');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
}
