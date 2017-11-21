<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\ConfirmBox;
use App\Model\Address;
use App\Model\GainLog;

use App\Model\Goods;
use App\Model\Player;
use App\Model\Users;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Widgets\Table;


class GainLogController extends Controller
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

            $content->header('提现列表');
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
        return Admin::grid(GainLog::class, function (Grid $grid) {

            $grid->disableCreation();
            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();

            $grid->user_id('用户名')->display(function ($uid){
                return Player::where('user_id',$uid)->first()->user_name;
            });
            $grid->goods_id('娃娃名称')->display(function ($gid){
                $ids = explode(',',$gid);
                $name = '';
                $nums = explode(',',$this->num);
                foreach ($ids as $key=>$id){
                    $name .= Goods::find($id)->name .'<br />';
                }
                return trim($name,'<br />');
            });
            $grid->column('nums','数量')->display(function (){
                $nums = explode(',',$this->num);
                $numss = '';
                foreach ($nums as $num){
                    $numss .= '×'. $num .'<br />';
                }
                return trim($numss,'<br />');
            });
            $grid->column('pic','娃娃图片')->display(function ($ggid){
                $ids = explode(',',$this->goods_id);
                $pic = '';
                foreach ($ids as $k=>$id){
                    if($k % 2 != 0){
                        $pic .= '<img src="/uploads/' . Goods::find($id)->pic . '" width="36">&nbsp;&nbsp;<br/>';
                    }else{
                        $pic .= '<img src="/uploads/' . Goods::find($id)->pic . '" width="36">&nbsp;&nbsp;';

                    }
                }
                return $pic;
            });
            $grid->address_info('收货信息');
//->display(function ($info){
//                $dzs = explode(',',$info);
//                return '收货人：' .$dzs[0].'<br>手机号码：' .$dzs[1].'<br>地区信息：' .$dzs[2].'<br>详细地址：' .$dzs[3].'<br>邮编：'.$dzs[4];
//            });
//            $grid->address_id('收货信息')->display(function ($aid){
//                $res = Address::find($aid);
//                return '收 货 人：'.$res->name .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;手机号码：'.$res->phone .'<br />' .
//                        '地区信息：'.$res->area_info .'&nbsp;&nbsp;&nbsp;&nbsp;邮政编码：'. $res->post_code .'<br />' .
//                        '详细地址：' . $res->address;
//            });
            $grid->status('状态')->display(function ($status){
                return $status == 1 ? "<span class='label label-success'>已发货</span>" : "<span class='label label-default'>未发货</span>";
            });

            $grid->actions(function ($actions){
                $actions->disableEdit();

                $status = GainLog::find($actions->getKey())->status;
                if($status == -1){
                    $actions->append(new ConfirmBox('确认发货吗？','gainlog/updateStatus',1));
                }
            });

            $grid->created_at('提现时间');
            //$grid->updated_at('');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(GainLog::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    // 自定义 发货方法
    public function updateStatus()
    {
        $res = GainLog::where('id', request('id'))->update(['status' => request('action')]);
        return $res ? ['status' => true,'message' => '已发货...'] : ['status' => false,'message' => '发货失败！'];
    }
}
