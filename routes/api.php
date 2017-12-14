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
       return strtolower(md5('RechargeLog' . env('GAMEKEY')));
    });
    $api->group(['namespace' => 'App\Http\Controllers\Api'],function($api){
        // 登录（旧）
        $api->post('login','LoginController@login');
        // 登录（新）
        //$api->post('login','LoginController@index');
        // 刷新token
        $api->get('refresh','LoginController@refreshToken');

        // 注册用户
//        $api->post('register','RegisterController@addUser');
        // 验证码
//        $api->get('verifycode','RegisterController@verifyCode');
        // 发送短信
//        $api->get('sendcode','RegisterController@sendCode');

        // 支付回调
        $api->post('notify','PayController@pay_notify');
        // 用户信息回调
        $api->get('unotify','DataNotifyController@userNotify');
        // 抓取记录回调
        $api->get('cnotify','DataNotifyController@catchLogNotify');
        // 娃娃机记录
        $api->get('dnotify','DataNotifyController@DollMachineLogNotify');
        // 完成任务回调
        $api->get('mnotify','DataNotifyController@missionedNotify');
        // 获取充值记录
        $api->get('rnotify','DataNotifyController@rechargeLogNotify');
        // 返佣增加用户金币
        $api->post('addrecoin','DataNotifyController@addRebateCoin');
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
        $api->get('pay/{id}','PayController@doPay');
        //$api->post('notify','PayController@pay_notify');

        // 抓娃娃
        $api->get('selectdm/{id}','CatchDollController@selectDollMachine'); // 选择了一个娃娃机
        $api->get('dollmachine','CatchDollController@getRandDollMachine');
        $api->post('catchdoll/{id}/{gid}','CatchDollController@catchDoll');
        // 返回娃娃互动信息
        $api->get('getdollinteraction','CatchDollController@getDollInteraction');
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
        // 返回积分
        $api->get('getpoint','MissionController@getUserPoint');
        // 兑换娃娃
        $api->get('exchange','MissionController@exchangeDoll');
        // 抓取到分享所需信息
        $api->get('getshare/{id}','CatchDollController@getShare');
        // 分享的jssdk
        $api->get('jssdk','UserController@getJsConfig');
        // 分享成功回调
        $api->get('sharewihtwx','BaseController@shareWithWx');
        // 分享的信息内容
        $api->get('sharedata','UserController@getShareData');

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