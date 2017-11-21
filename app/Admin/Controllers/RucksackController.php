<?php

namespace App\Admin\Controllers;

use App\Model\Goods;
use App\Model\UserRucksack;

use App\Model\Users;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class RucksackController extends Controller
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

            $content->header('提现');
            $content->description('提现列表');

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
        return Admin::grid(UserRucksack::class, function (Grid $grid) {

            $grid->model()->orderBy('id', 'desc');

            $grid->disableCreation();

            $grid->id('ID')->sortable();

            $grid->user_id('用户名')->display(function ($uid){
               return Users::find($uid)->nickname;
            });
            $grid->goods_id('娃娃名称')->display(function ($gid){
                $ids = explode(',',$gid);
                return Goods::find($ids)->name;
            });
            $grid->column('pic','娃娃图片')->display(function ($ggid){
               return '<img src="/uploads/' . Goods::find($this->goods_id)->pic . '" width="36">';
            });
            $grid->status('状态')->display(function ($status){
                return $status == 1 ? "<span class='label label-success'>已提现</span>" : "<span class='label label-default'>未提现</span>";
            });

            $grid->withdraw_time('提现时间');
            $grid->gain_time('获取时间');
            $grid->actions(function ($actions) {
                $actions->disableEdit();
            });
           //$grid->created_at();
           // $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(UserRucksack::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
