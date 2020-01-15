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

/**Gitpull----拉取代码*/
Route::any('pull','Git\GitpullController@pull');

/**后台分组*/
Route::prefix('admin')->group(function () {

    //后台首页
    Route::get('/index','Admin\AdminController@index');

    //后台主页
    Route::get('/home','Admin\AdminController@home');

    //phpinfo
    Route::any('/test','Admin\AdminController@test');

    //获取天气信息
    Route::get('/getWeather','Admin\AdminController@getWeather');
});

/**登录分组*/
Route::prefix('login')->group(function () {

    //登录
    Route::get('/login','Admin\LoginController@login');

    //执行登录
    Route::post('/loginDo','Admin\LoginController@LoginDo');

});

/**微信分组*/
Route::prefix('wechat')->group(function () {
    //Route::get('/wechat','Wechat\WechatController@aaa');
    Route::any('/wechat','Wechat\WechatController@wechat');
    //群发视图
    //Route::any('/wechat','Wechat\WechatController@wechat');
    //微信群发
    Route::any('/sendAllByOpenId','Wechat\WechatController@sendAllByOpenId');

});

/**素材管理分组*/
Route::prefix('material')->group(function () {

    //素材添加
    Route::get('/create','Admin\MaterialController@create');

    //执行素材添加
    Route::post('/store','Admin\MaterialController@store');

    //素材列表
    Route::get('/index','Admin\MaterialController@index');

});

/**新闻管理分组*/
Route::prefix('news')->group(function () {

    //新闻添加
    Route::get('/create','Admin\NewsController@create');

    //执行新闻添加
    Route::post('/store','Admin\NewsController@store');

    //新闻列表
    Route::get('/index','Admin\NewsController@index');

    //新闻删除
    Route::get('/destroy/{id}','Admin\NewsController@destroy');

    //新闻编辑
    Route::get('/edit/{id}','Admin\NewsController@edit');

    //执行新闻编辑
    Route::post('/update/{id}','Admin\NewsController@update');

});

/**渠道管理分组*/
Route::prefix('channel')->group(function () {

    //渠道添加
    Route::get('/create','Admin\ChannelController@create');

    //执行渠道添加
    Route::post('/store','Admin\ChannelController@store');

    //渠道展示
    Route::get('/index','Admin\ChannelController@index');

    //生成带参数的二维码
    Route::get('/createCode','Admin\ChannelController@createCode');

    //渠道统计图表
    Route::get('/statistical','Admin\ChannelController@statistical');

});

/**菜单管理分组*/
Route::prefix('menu')->group(function () {

    //菜单添加
    Route::get('/create','Admin\MenuController@create');

    //执行菜单添加
    Route::post('/store','Admin\MenuController@store');

    //菜单展示
    Route::get('/index','Admin\MenuController@index');

    //创建菜单
    Route::get('/createMenu','Admin\MenuController@createMenu');

});





