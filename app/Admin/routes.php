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
//    $router->get('goods/index','GoodsController@index');
//    $router->get('goods/index/create','GoodsController@create');
});
