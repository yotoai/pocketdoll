<?php

namespace App\Admin\Controllers;

use App\Model\Awards;
use App\Model\Mission;

use App\Model\missionType;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class MissionController extends Controller
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

            $content->header('任务管理');
            $content->description('列表');

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

            $content->header('编辑任务');
            $content->description('编辑');

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

            $content->header('创建任务');
            $content->description('创建');

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
        return Admin::grid(Mission::class, function (Grid $grid) {

            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();

            $grid->title('任务名称');
            $grid->award_id('奖励')->display(function ($aid){
               return Awards::find($aid)->contents;
            });
            $grid->need_num('所需完成次数/天数');
            $grid->icon('任务图标')->image('/uploads/',36,36);

            $grid->created_at('创建时间');
            $grid->updated_at('修改时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Mission::class, function (Form $form) {

            $form->display('id', 'ID：');

            $form->select('parent_id','父级任务：')->options(Mission::selectOptions(1))->help($this->iconHelp());
            $form->text('title','任务名称：')->rules('required|max:255');
            $form->select('type','任务类型：')->options(function ($type){
                return missionType::all()->pluck('title','id')->toArray();
            });
            $form->select('award_id','奖励：')->options(function (){
                return Awards::all()->pluck('contents','id')->toArray();
            });
            $form->number('need_num','所需完成次数/天数：')->rules('required|integer');
            $form->image('icon','任务图标：');


            $form->display('created_at', '创建时间：');
            $form->display('updated_at', '修改时间：');
        });
    }

    protected function iconHelp()
    {
        return '<span style="color: red;">如果没有前置任务，无需选择...</span>';
    }
}
