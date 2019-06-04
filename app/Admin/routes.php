<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
        $router->resource('/goods', GoodsController::class);//商品
        $router->resource('/order', OrderController::class);//订单
       $router->resource('/weixin', WxController::class);//微信
       $router->resource('/weixinText', WxTextController::class);
       //$router->post('/weiimg/fodder', 'WxTextController@add');
       Route::post('fodder','WxTextController@add');//微信获取素材添加
    $router->resource('/fodderLiset', FodderLisetController::class);//素材展示
    Route::get('/messageAss','WxController@add');//微信
});
