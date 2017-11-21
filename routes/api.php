<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function () {
//    return 1;
//});
$api = app('Dingo\Api\Routing\Router');

$api->version('v1',function($api){
    // 测试 代码放置处
    $api->get('test',function (){
        return ;
    });
    $api->group(['namespace' => 'App\Http\Controllers\Api'],function($api){
        // 登录（旧）
        $api->post('login','LoginController@login');
        // 登录（新）
        //$api->post('login','LoginController@index');
        // 刷新token
        $api->get('refresh','LoginController@refreshToken');

        // 注册用户
        $api->post('register','RegisterController@addUser');
        // 验证码
        $api->get('verifycode','RegisterController@verifyCode');
        // 发送短信
        $api->get('sendcode','RegisterController@sendCode');

        // 支付回调
        $api->post('notify','PayController@pay_notify');
    });

    $api->group(['middleware' => ['api.reftoken'],'namespace' => 'App\Http\Controllers\Api'],function($api){
//    $api->group(['namespace' => 'App\Http\Controllers\Api'],function($api){
        // 公告
        $api->get('notice','NoticeController@qnotice');

        // 玩家秀
        $api->get('usershow','UserShowController@userShow');
        $api->post('addusershow','UserShowController@addUserShow');

        // 充值额度
        $api->get('rechargeamount','RechargeAmountController@rechargeAmount');
        // 支付
        $api->post('pay','PayController@doPay');
        //$api->post('notify','PayController@pay_notify');

        // 抓娃娃
        $api->get('selectdm/{id}','CatchDollController@selectDollMachine'); // 选择了一个娃娃机
        $api->get('dollmachine','CatchDollController@getRandDollMachine');
        $api->post('catchdoll/{id}/{gid}','CatchDollController@catchDoll');
        // 用户背包
        $api->get('rucksack','UserRucksackController@rucksack');
        $api->post('withdrawdoll','UserRucksackController@withdrawDoll');
        $api->post('withdrawlog','UserRucksackController@withdrawLog');
        $api->get('address','UserRucksackController@getAddress');
        // 任务
        $api->get('mission','MissionController@dayMission');
        $api->get('invite','MissionController@inviteMission');
        $api->get('daymission','MissionController@loginInMission');
        $api->post('finishmission/{id}','MissionController@finishMission');

        // 分享所需信息
        $api->get('getshare/{id}','CatchDollController@getShare');
        // 分享
        $api->get('jssdk','UserController@getJsConfig');
        // 分享回调
        $api->get('sharewihtwx','BaseController@shareWithWx');

        //获取二维码
        $api->get('qrcode','BaseController@getQrCode');
        // 返回虚拟信息
        $api->get('randdata','BaseController@getfakename');
        // 返回弹幕
        $api->get('barrage/{id}','BaseController@getBarrage');
        // 返回帮助中心信息
        $api->get('helpinfo','NoticeController@helpinfo');

    });

//
    $api->group(['middleware' => ['api', 'wechat.oauth'],'namespace' => 'App\Http\Controllers\Api'], function ($api) {
        // 用户授权
//        $api->get('user','UserController@oauthUser');
//        // 充值
//        $api->post('wxpay/{id}','WxpayController@Wxpay');
//        $api->post('wxnotify','WxpayController@wxNotify');
//        // 分享
        $api->get('wxjssdk','UserController@getJsConfig');
//        // 刷新token
//        $api->get('refresh','UserController@refreshToken');
    });
});