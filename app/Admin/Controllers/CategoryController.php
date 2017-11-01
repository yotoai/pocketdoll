<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\ConfirmBox;
use App\Model\Goods;
use App\Model\GoodsCategory;

use App\Model\Tags;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\Redis;

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

            $grid->status('状态')->display(function ($status){
                return $status == 1 ?  "<span class='label label-success'>已上架</span>" : "<span class='label label-default'>已下架</span>";
            });

            $grid->actions(function ($actions){
                $status = GoodsCategory::find($actions->getKey())->status;
                if($status == '-1'){
                    $actions->append(new ConfirmBox('确认上架吗？','machine/updateStatus',$status));
                }elseif ($status == '1'){
                    $actions->append(new ConfirmBox('确认下架吗？','machine/updateStatus',$status,'fa-close'));
                }
            });
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
            });
//            $form->multipleSelect('tag_id','标签：')->options(Tags::all()->pluck('tag_name','id'))->rules('required');
            $form->number('win_rate','概率：')->rules('required');
            $form->image('pic','图片：')->rules('required');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    // 自定义 上下架方法
    public function updateStatus()
    {
        $res = GoodsCategory::where('id', request('id'))->update(['status' => request('action') == '-1' ? '1' : '-1']);
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
