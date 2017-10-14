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
    // 公告/活动
    $router->resource('notice',NoticeController::class,['as' => 'admin']);

    // 就是这个
    $router->post('usershow/updateStatus', 'UserShowController@updateStatus')->name('admin.usershow.updateStatus');

    $router->resource('usershow',UserShowController::class,['as' => 'admin']);

    // 任务&充值
    $router->resource('mission',MissionController::class,['as' => 'admin']);
    $router->resource('recharge',RechargeController::class,['as' => 'admin']);
    $router->resource('rechargeLog',RechargeLogController::class,['as' => 'admin']);
});
