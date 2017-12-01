<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\ConfirmBox;
use App\Model\Goods;

use App\Model\GoodsCategory;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\Redis;

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
            // 添加默认查询条件
            $grid->model()->where('status', '=', 1);
            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();
            $grid->actions(function ($actions) {
                $actions->disableDelete();
                $actions->append(new ConfirmBox('确认删除吗？','goods/updateStatus','-1','fa-trash','float-right'));
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
            $form->display('id', 'ID：');
            $form->text('name','商品名称：')->rules('required|max:255');
            $cate = GoodsCategory::all(['id','cate_name'])->pluck('cate_name','id')->toArray();
            $form->select('goods_cate_id','娃娃机：')->options($cate);
            $form->number('add_num','向娃娃机添加的个数：')->default(1)->rules('min:1|max:6|numeric');
            $form->number('width','娃娃宽度：')->rules('required|min:1');
            $form->number('height','娃娃高度：')->rules('required|min:1');
            $form->number('xdheight','娃娃相对高度：')->rules('required')->help('抓取位置与娃娃高度的相对位置');
            $form->image('pic','展示图片：')->rules('required');
            $form->image('sc_pic','素材图片：')->rules('required');
            $form->display('created_at', '添加时间：');
            $form->display('updated_at', '修改时间：');
            $form->saving(function (Form $form){
                //保存之前的操
            });
            $form->saved(function (Form $form){
                //保存之后的操作
                    Redis::del('doll_machine');
                    $key = 'doll_machine';
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

    // 自定义 软删除方法
    public function updateStatus()
    {
        $res = Goods::where('id', request('id'))->update(['status' => request('action')]);
        if($res){
            Redis::del('doll_machine');
            $key = 'doll_machine';
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
        }
        return $res ? ['status' => true,'message' => '操作成功'] : ['status' => false,'message' => '操作失败！'];
    }
}
