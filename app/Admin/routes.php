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

    // 修改 状态
    $router->post('usershow/updateStatus', 'UserShowController@updateStatus')->name('admin.usershow.updateStatus');
    $router->post('gainlog/updateStatus', 'GainLogController@updateStatus')->name('admin.gainlog.updateStatus');

    // 任务管理
    $router->resource('mission',MissionController::class,['as' => 'admin']);
    $router->resource('awards',AwardsController::class,['as' => 'admin']);
    $router->resource('missionlog',MissionLogController::class,['as' => 'admin']);

    // 充值管理
    $router->resource('recharge',RechargeController::class,['as' => 'admin']);
    $router->resource('rechargeLog',RechargeLogController::class,['as' => 'admin']);
});
