<?php

namespace App\Admin\Controllers;

use App\Model\Mission;
use App\Model\Player;
use App\Model\UserMission;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class MissionLogController extends Controller
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

            $content->header('任务日志');
            $content->description('用户完成任务列表');

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

            $content->header('header');
            $content->description('description');

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
        return Admin::grid(UserMission::class, function (Grid $grid) {

            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();

            $grid->disableCreation();
            $grid->user_id('用户名')->display(function ($uid){
                $u = Player::where('user_id',$uid)->first();
                if(empty($u)){
                    return '未知用户';
                }else{
                    return $u->user_name;
                }
            });
            $grid->mission_id('任务名称')->display(function ($mid){
                if($mid == -11){
                    return '兑换娃娃任务';
                }
                $m = Mission::find($mid);
                if(empty($m->title)){
                    return '未知任务';
                }else{
                    return $m->title;
                }
            });
            $grid->status('是否完成？')->display(function ($st){
                return $st == 1 ? '<sapn class="label label-success">是</sapn>' : '<span class="label label-default"> 否</span>';
            });

            $grid->created_at('完成时间');
            //$grid->updated_at();
            $grid->actions(function ($actions) {
                $actions->disableEdit();
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
        return Admin::form(UserMission::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
