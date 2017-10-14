<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\ConfirmBox;
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

            $grid->id('ID')->sortable();

            $grid->user_id('玩家名称')->display(function ($uid){
                return Users::find($uid)->nickname;
            });
//            $grid->pic('图秀')->image('',36,36);

            $grid->contents('内容');

            $grid->actions(function ($actions){
                $actions->append(new ConfirmBox($actions->getKey()));
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
        $id = request('id');
        return UserShow::where('id', $id)->update(['status' => request('action')]);
    }
}
