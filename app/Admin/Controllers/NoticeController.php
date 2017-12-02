<?php

namespace App\Admin\Controllers;

use App\Model\Notice;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class NoticeController extends Controller
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

            $content->header('公告');
            $content->description('通知公告');

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
            $content->description('编辑公告');

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
            $content->description('添加公告');

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
        return Admin::grid(Notice::class, function (Grid $grid) {

            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();

            $grid->title('公告名');
            $grid->pic('图片')->image('/uploads/',36,36);
            $grid->contents('公告内容');

            $grid->created_at('添加时间');
            $grid->updated_at('更新时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Notice::class, function (Form $form) {

            $form->display('id', 'ID：');

            $form->text('title','公告名称：')->rules('required');
            $form->textarea('contents','公告内容：')->rules('required');
            $form->image('pic','图片：');


            $form->display('created_at', '添加时间：');
            $form->display('updated_at', '修改时间：');
        });
    }
}
