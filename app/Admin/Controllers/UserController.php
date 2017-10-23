<?php

namespace App\Admin\Controllers;

use App\Model\Users;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class UserController extends Controller
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

            $content->header('玩家列表');
            $content->description('所有玩家的列表');

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

            $content->header('编辑');
            $content->description('编辑玩家信息');

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

            $content->header('添加');
            $content->description('添加个玩家');

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
        return Admin::grid(Users::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->nickname('用户昵称');
            $grid->icon('用户头像')->display(function ($icon){
                return '<img src="/uploads/'.$icon.'">';
            });
            $grid->coin('持有金币');
            $grid->login_time('最近登录时间');

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
        return Admin::form(Users::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('nickname','昵称：')->rules('required|max:255');
            $form->number('coin','金币：');
            $form->image('icon','头像')->rules('required');

            $form->display('created_at', '创建时间：');
            $form->display('updated_at', '更新时间：');
        });
    }
}
