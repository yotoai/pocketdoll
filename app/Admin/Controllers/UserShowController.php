<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\ConfirmBox;
use App\Model\Player;
use App\Model\Users;
use App\Model\UserShow;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\Request;

class UserShowController extends Controller
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

            $content->header('玩家秀');
            $content->description('玩家秀列表');

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
            $content->description('编辑玩家秀');

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
            $content->description('添加玩家秀');

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
        return Admin::grid(UserShow::class, function (Grid $grid) {

            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();

            $grid->user_id('玩家名称')->display(function ($uid){
                return Player::where('user_id',$uid)->first()->user_name;
            });
            $grid->pic('图秀')->image('/uploads/',36,36);

            $grid->contents('内容');

            $grid->status('审核状态')->display(function($status){
                return $status == 1 ?  "<span class='label label-success'>审核通过</span>" : "<span class='label label-default'>未审核</span>";
            });

            $grid->actions(function ($actions){
                $status = UserShow::find($actions->getKey())->status;
                if($status != 1){
                    $actions->append(new ConfirmBox('确认通过吗？','usershow/updateStatus',1));
                }
            });

            $grid->created_at('上传时间');
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
        return Admin::form(UserShow::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('user_id','玩家名称：');
            $form->image('pic','图秀');
            $form->textarea('contents','内容');

            $form->display('created_at', '添加时间');
            $form->display('updated_at', '修改时间');
        });
    }

    // 自定义 审核方法
    public function updateStatus()
    {
        $res = UserShow::where('id', request('id'))->update(['status' => request('action')]);
        return $res ? ['status' => true,'message' => '已通过...'] : ['status' => false,'message' => '审核通过失败！'];
    }


}
