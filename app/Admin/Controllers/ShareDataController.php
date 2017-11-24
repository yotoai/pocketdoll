<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\ConfirmBox;
use App\Model\ShareData;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ShareDataController extends Controller
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

            $content->header('微信分享数据');
            $content->description('微信分享数据列表');

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
            $content->description('编辑分享数据');

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
            $content->description('创建分享数据');

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
        return Admin::grid(ShareData::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->title('分享标题');
            $grid->desc('分享描述');
            $grid->links('分享链接')->display(function($text) {
                return str_limit($text, 30, '...');
            });;
            $grid->img_url('分享图标')->image('/uploads/',35,35);
            $grid->status('是否启用')->display(function ($s){
                return $s == '1' ? "<span class='label label-success'>是</span>" : "<span class='label label-default'>否</span>";
            });

            $grid->actions(function ($actions){
                $status = ShareData::find($actions->getKey())->status;
                if($status == '-1'){
                    $actions->append(new ConfirmBox('确认启用吗？','share/updateStatus',1));
                }
            });

            $grid->created_at('添加时间');
           // $grid->updated_at('修改时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ShareData::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('title','分享标题：')->rules('required|max:255');
            $form->text('desc','分享描述：')->rules('required|max:255');
            $form->url('links','分享的链接：')->rules('required');
            $form->image('img_url','分享的图标')->rules('required');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');

        });
    }

    // 自定义 上下架方法
    public function updateStatus()
    {
        $res = ShareData::where('id', request('id'))->update(['status' => request('action')]);
        if($res){
            ShareData::where('status','1')->where('id','<>',request('id'))->update(['status'=>'-1']);
        }
        return $res ? ['status' => true,'message' => '操作成功'] : ['status' => false,'message' => '操作失败！'];
    }
}
