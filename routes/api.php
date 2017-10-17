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
    //$api->group(['middleware' => 'api.auth','namespace' => 'App\Http\Controllers\Api'],function($api){
    $api->group(['namespace' => 'App\Http\Controllers\Api'],function($api){
    // 公告
        $api->get('notice','NoticeController@qnotice');
//        $api->get('hnotice','NoticeController@hnotice');
//        $api->post('addnotice','NoticeController@addNotice');
//        $api->post('delnotice/{id}','NoticeController@deleteNotice');
//        $api->post('upnotice/{id}','NoticeController@updateNotice');
//        $api->post('upnoticestatus/{id}','NoticeController@updateNoticeStatus');
        // 娃娃
//        $api->get('goods','GoodsController@goods');
//        $api->post('addgoods','GoodsController@addGoods');
//        $api->post('delgoods/{id}','GoodsController@deleteGoods');
//        $api->post('upgoods/{id}','GoodsController@updateGoods');
        // 玩家秀
        $api->get('usershow','UserShowController@userShow');
//        $api->post('addusershow','UserShowController@addUserShow');
//        $api->post('delusershow/{id}','UserShowController@deleteUserShow');
//        $api->post('upusershowstatus/{id}','UserShowController@updateUserShowStatus');
        // 充值额度
        $api->get('rechargeamount','RechargeAmountController@rechargeAmount');
//        $api->post('addrechargeamount','RechargeAmountController@addRechargeAmount');
//        $api->post('uprechargeamount/{id}','RechargeAmountController@updateRechargeAmont');
//        $api->post('delrechargeamount/{id}','RechargeAmountController@deleteRechargeAmount');
        // 抓娃娃
        $api->get('selectdm/{id}','CatchDollController@selectDollMachine'); // 选择了一个娃娃机
        $api->get('dollmachine','CatchDollController@getRandDollMachine');
        $api->post('catchdoll/{id}/{gid}','CatchDollController@catchDoll');
        // 用户背包
        $api->get('rucksack/{uid}','UserRucksackController@rucksack');
        $api->post('withdrawdoll/','UserRucksackController@withdrawDoll');
        $api->post('withdrawlog/{id}','UserRucksackController@withdrawLog');
        // 任务
        $api->get('mission','MissionController@dayMission');
        $api->get('daymission','MissionController@loginInMission');
//        $api->post('addmission','MissionController@addMission');
//        $api->post('upmission/{id}','MissionController@updateMission');
//        $api->post('delmission/{id}','MissionController@deleteMission');
        // 任务类型
        // $api->get('missiontype','MissionController@missionType');
        // $api->post('addmissiontype','MissionController@addMissionType');
    });
    $api->group(['middleware' => ['api', 'wechat.oauth'],'namespace' => 'App\Http\Controllers\Api'], function ($api) {
        // 用户授权
        $api->get('/user','UserController@oauthUser');
        // 充值
        $api->post('wxpay/{id}','WxpayController@Wxpay');
        $api->post('wxnotify','WxpayController@wxNotify');
    });
});