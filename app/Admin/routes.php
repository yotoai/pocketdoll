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
    $router->resource('usershow',UserShowController::class,['as' => 'admin']);
});
