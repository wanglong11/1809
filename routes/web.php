<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');//登录注册
Route::get('/goods', 'good\GoodsController@index');//商品展示
Route::get('/goods/detail/{id}', 'good\GoodsController@detail');//商品详情
//Route::get('/goods/detail/{id}', 'good\GoodsController@cacheGoods');//哈希测试缓存
Route::get('/goods/sort', 'good\GoodsController@getsort');//缓存浏览历史
Route::get('/cart', 'CartController@index');//购物车页面
Route::get('/add/{id?}', 'CartController@AddCart');//添加购物车数据
//订单处理
Route::get('/order/create', 'Order\IndexController@create');      //生成订单
Route::get('/order/lists', 'Order\IndexController@oList');      //订单列表
Route::get('/order/paystatus/{id}', 'Order\IndexController@payStatus');      //查询订单支付状态


//微信支付
Route::get('/pay/weixin', 'PayController@pay');
Route::post('/weixin/pay/notify','PayController@notify');//微信回调


//支付
Route::get('/pay/success', 'PayController@paySuccess');      //微信支付成功
//jssdk测试
Route::get('/weixin/jssdk','weixin\jssdkController@jssdk'); //微信jssdk开发
Route::get('/wx/js/getImg', 'weixin\jssdkController@getImg');      //获取JSSDK上传的照片
//测试生产二维码
//Route:post('/weixin/QRcode','QRcodeController@index');
Route::get('/weixin/QRcode','QRcodeController@index');//微信回调