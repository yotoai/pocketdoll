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
    return redirect('index.html#/login');
});



Route::group(['middleware' => ['web', 'wechat.oauth']], function () {
    Route::get('/user', function () {
        $user = session('wechat.oauth_user'); // 拿到授权用户资料

        dd($user);
    });
});

Route::get('notify_index',function (){
    $uid = isset($_GET['user_id']) ? $_GET['user_id'] : '';
    if(empty($uid)){
        $url = 'http://114.215.106.114:8081/sdk_new/tdpay/gameLogin.do?sdkId=2098&sign=e4d2be517a26de831f024c5bdbd307ab&loginType=mplogin';
    }else{
        $sign = strtolower(md5(2098 . $uid . 'shareLogin' . env('GAMEKEY')));
        $url = 'http://114.215.106.114:8081/sdk_new/tdpay/gameLogin.do?sdkId=2098&userId='.$uid.'&loginType=shareLogin&sign='.$sign;
    }
    return redirect($url);
});