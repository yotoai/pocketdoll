<?php

namespace App\Admin\Controllers;

use App\Model\GoodsCategory;
use App\Model\TalkExpression;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class TalkExpressionController extends Controller
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

            $content->header('娃娃互动');
            $content->description('娃娃互动对话表情列表');

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
            $content->description('编辑娃娃互动');

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
            $content->description('创建娃娃互动');

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
        return Admin::grid(TalkExpression::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->dollmachine_id('娃娃机')->display(function ($dmid){
                $data = GoodsCategory::find($dmid);
                if(empty($data->cate_num)){
                    return '没有选择娃娃机';
                }else{
                    return $data->cate_name;
                }
            });
            $grid->talk_doll('互动');
            $grid->small_expression('表情')->display(function ($se){
                $str = '';
                foreach ($se as $v){
                    $str .= '<img src="/uploads/' .$v. '" width="35" />';
                }
                return $str;
            });
            $grid->type('触发情况')->display(function ($t){
                return $t == 1 ? '抓取时触发' : ( $t == 2 ? '掉落触发' : '静止时随机触发' );
            });
            $grid->created_at('创建时间');
//            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(TalkExpression::class, function (Form $form) {

            $form->display('id', 'ID：');

            $form->select('dollmachine_id','娃娃机：')->options(function (){
                return GoodsCategory::all(['id','cate_name'])->pluck('cate_name','id')->toArray();
            });
            $form->text('talk_doll','娃娃对话：')->help('如有多句，请用英文 , 隔开');
            $form->multipleImage('small_expression','小表情：')->removable()->help('如有多个，请在浏览时选择多张图片');
            $form->select('type','触发情况：')->options([1=>'抓取时触发',2=>'掉落触发',3=>'静止时随机触发']);
            $form->display('created_at', '创建时间：');
            $form->display('updated_at', '修改时间：');
        });
    }
}
