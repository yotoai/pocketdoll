<?php

namespace App\Admin\Controllers;

use App\Model\GoodsCategory;

use App\Model\Tags;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class CategoryController extends Controller
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

            $content->header('娃娃机');
            $content->description('娃娃机列表');

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
            $content->description('编辑娃娃机');

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
            $content->description('添加娃娃');

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
        return Admin::grid(GoodsCategory::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->cate_name('娃娃机名称');
            $grid->pic('图片')->image('/uploads/',36,36);
            $grid->spec('规格/cm');
            $grid->coin('金币');
            $grid->tag_id('标签')->display(function ($tag_id){
                return Tags::find($tag_id)->tag_name;
            });
            $grid->win_rate('概率');

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
        return Admin::form(GoodsCategory::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('cate_name','娃娃机名称：')->rules('required');
            $form->number('spec','规格：')->rules('required');
            $form->number('coin','金币：')->rules('required');
            $form->select('tag_id','标签：')->options(function(){
                return Tags::all()->pluck('tag_name','id')->toArray();
            })->rules('required');
            $form->number('win_rate','概率：')->rules('required');
            $form->image('pic','图片：')->rules('required');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
