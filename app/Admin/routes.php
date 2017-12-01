<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');

    // 商品管理
    $router->resource('goods',GoodsController::class,['as' => 'admin']);
    $router->resource('machine',CategoryController::class,['as' => 'admin']);
    $router->resource('tags',TagsController::class,['as' => 'admin']);
    $router->resource('gainlog',GainLogController::class,['as' => 'admin']);
    $router->resource('catchlog',CatchLogController::class,['as' => 'admin']);

//    $router->resource('rucksack',RucksackController::class,['as' => 'admin']);
    // 公告/活动
    $router->resource('notice',NoticeController::class,['as' => 'admin']);
    $router->resource('usershow',UserShowController::class,['as' => 'admin']);

    // 任务管理
    $router->resource('mission',MissionController::class,['as' => 'admin']);
    $router->resource('awards',AwardsController::class,['as' => 'admin']);
    $router->resource('missionlog',MissionLogController::class,['as' => 'admin']);

    // 充值管理
    $router->resource('recharge',RechargeController::class,['as' => 'admin']);
    $router->resource('rechargeLog',RechargeLogController::class,['as' => 'admin']);

    // 用户管理
    $router->resource('player',PlayerController::class,['as' =>'admin']);
    // 帮助中心
    $router->resource('helpcenter',HelpCenterController::class,['as' => 'admin']);
    // 分享设置
    $router->resource('share',ShareDataController::class,['as' => 'admin']);
    // 佣金配置
    $router->resource('interaction',TalkExpressionController::class,['as' => 'admin']);
    // $router->resource('config',ChargeConfigController::class,['as' => 'admin']);
    // 修改 状态
    $router->post('usershow/updateStatus', 'UserShowController@updateStatus')->name('admin.usershow.updateStatus');
    $router->post('gainlog/updateStatus', 'GainLogController@updateStatus')->name('admin.gainlog.updateStatus');
    $router->post('machine/updateStatus', 'CategoryController@updateStatus')->name('admin.machine.updateStatus');
    $router->post('goods/updateStatus', 'GoodsController@updateStatus')->name('admin.goods.updateStatus');
    $router->post('share/updateStatus', 'ShareDataController@updateStatus')->name('admin.share.updateStatus');
});
