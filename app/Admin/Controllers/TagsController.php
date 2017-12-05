<?php

namespace App\Admin\Controllers;

use App\Model\Goods;
use App\Model\GoodsCategory;
use App\Model\Tags;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Row;
use Illuminate\Support\Facades\Redis;

class TagsController extends Controller
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

            $content->header('标签');
            $content->description('娃娃的标签');

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
            $content->description('编辑标签');

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

            $content->header('创建');
            $content->description('创建标签');

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
        return Admin::grid(Tags::class, function (Grid $grid) {
            $grid->id('ID')->sortable();

            $grid->tag_name('标签名');
            $grid->tag_icon('图片')->image('/uploads/',36,36);

            $grid->created_at('创建时间');
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
        return Admin::form(Tags::class, function (Form $form) {


            $form->display('id', 'ID：');

            $form->text('tag_name','标签名称：')->rules('required');
            $form->image('tag_icon','图片：')->rules('required');

            $form->display('created_at', '创建时间：');
            $form->display('updated_at', '修改时间：');

            $form->saved(function (Form $form){
                $key = 'doll_machine';
                Redis::del('doll_machine');
                $cate_id = Goods::where('status','<>','-1')->distinct()->get(['goods_cate_id'])->pluck('goods_cate_id');
                $data = GoodsCategory::join('goods_tags_cate','goods_tags_cate.id','=','goods_category.tag_id')
                    ->whereIn('goods_category.id',$cate_id)
                    ->where('goods_category.status','<>','-1')
                    ->get([
                        'goods_category.id as id',
                        'goods_category.cate_name as name',
                        'goods_category.spec as spec',
                        'goods_category.coin as coin',
                        'goods_category.pic as pic',
                        'goods_tags_cate.tag_icon as tag_icon'
                    ]);
                foreach ($data as $d){
                    $d->pic = env('APP_URL').'/uploads/'.$d->pic;
                    $d->tag_icon = env('APP_URL').'/uploads/'.$d->tag_icon;
                }
                foreach ($data as $item) {
                    Redis::sadd($key, $item);
                }
            });
        });
    }
}
