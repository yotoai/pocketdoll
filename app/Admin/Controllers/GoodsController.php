<?php

namespace App\Admin\Controllers;

use App\Model\Goods;

use App\Model\GoodsCategory;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class GoodsController extends Controller
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

            $content->header('列表');
            $content->description('所有商品的列表');

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

            $content->header('添加');
            $content->description('添加一个娃娃');

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
        return Admin::grid(Goods::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->actions(function ($actions) {
                $actions->disableDelete();

            });

            $grid->name('商品名称');
            $grid->pic('图片')->image('/uploads/',36,36);
            $grid->goods_cate_id('所属娃娃机')->display(function($category){
                return GoodsCategory::find($category)->cate_name;
            });
            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');

            // 搜索
            $grid->filter(function($filter){
                $filter->between('created_at','创建时间：')->datetime();
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Goods::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('name','商品名称：')->rules('required|max:255');
            $cate = GoodsCategory::all(['id','cate_name'])->pluck('cate_name','id')->toArray();
            $form->select('goods_cate_id','娃娃机：')->options($cate);
            $form->number('width','娃娃宽度：')->rules('required');
            $form->number('height','娃娃高度：')->rules('required');
            $form->image('pic','展示图片：');
            $form->image('sc_pic','素材图片：')->rules('required');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
            $form->saving(function (Form $form){
                //保存之前的操作
            });
            $form->saved(function (Form $form){
                //保存之前的操作
            });
        });
    }
}
