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
Auth::routes();



Route::group(['middleware' => 'cross'],function(){
//  注册
Route::post('register', 'API\Account\AccountController@register');

// 登录
Route::post('login', 'API\Account\AccountController@login')->name('login');

Route::apiResource('goods_type', 'API\GoodsType\GoodsTypeController');

Route::get('get-second-type', 'API\GoodsType\GoodsTypeController@getSecondTypeWithId');

Route::get("goods-list","API\Goods\GoodsController@goodsList");

// 权限自动更新 （开发使用）
Route::get('init-permission', 'API\Config\InitController@initPermission');

Route::get('goods/export', 'API\Goods\GoodsController@exportGoods');
// 认证用户接口

Route::namespace('API')->middleware(['auth:api'])->group(function () {

    Route::get("config",'Config\ConfigController@getDefaultValue');
    Route::post("config",'Config\ConfigController@setDefaultValue');

    // 用户
    Route::apiResource('users', 'Account\AccountController');
    // 角色
    Route::apiResource('roles', 'RoleController');
    // 获取角色的权限
    Route::get('roles/{role}/permissions', 'RoleController@permissions')->name('role.permissions.index');
    // 获取角色的用户
    Route::get('roles/{role}/users', 'RoleController@users')->name('role.users.index');
    // 权限
    Route::apiResource('permissions', 'PermissionController');

    // 角色-同步权限
    Route::put('roles/{role}/permissions', 'RoleController@syncPermissions')->name('role.permissions.sync');
    // 角色-添加权限
    Route::post('roles/{role}/permissions', 'RoleController@attachPermissions')->name('role.permissions.add');

    // 角色-同步用户
    Route::put('roles/{role}/users', 'RoleController@syncUsers')->name('role.users.sync');
    // 角色-添加用户
    Route::post('roles/{role}/users', 'RoleController@attachUsers')->name('role.users.add');
    // 角色-全部权限
    Route::get('roles/{role}/permissions', 'RoleController@permissions')->name('role.permissions.index');
    // 角色-全部用户
    Route::get('roles/{role}/users', 'RoleController@users')->name('role.users.index');

    // 个人
    Route::prefix('personal')->group(function () {

        // 获取用户个人信息password
        Route::get('/', 'Account\AccountController@getMeInfo');
        // 退出登录
    });
    Route::post('logout', 'Account\AccountController@logout');

    Route::get('user/martket', 'Account\AccountController@getMarketList');

    Route::get('user/list', 'Account\AccountController@getUserList');

    Route::get('user/details', 'Account\AccountController@getUserDetail');

    Route::post('user/update-phone', 'Account\AccountController@updatePhone');

    Route::post('user/update-password', 'Account\AccountController@updatePassword');


    Route::apiResource('supplier', 'Supplier\SupplierController');

    Route::apiResource('distribution', 'Distribution\DistributionController');

    Route::apiResource('order', 'Order\OrderController');
    Route::get('get-self-order', 'Order\OrderController@getOrderWithUserid');


    Route::apiResource('goods', 'Goods\GoodsController');


    Route::post("goods-often","Goods\GoodsController@oftenBrowse");
    Route::get("get-goods-often","Goods\GoodsController@getOftenBrowse");

    Route::get("get-search-goods","Goods\GoodsController@searchGoods");

    Route::get("get-history","Goods\GoodsController@getHistorySearch");

    Route::put("delete-history","Goods\GoodsController@deleteHistorySearch");

    Route::get("get-hot","Goods\GoodsController@getHotSearch");

    Route::post('goods/upload', 'Goods\GoodsController@uploadGoodsImage');

    Route::post('goods/import', 'Goods\GoodsController@importGoods');



    Route::apiResource('goods_type_second', 'GoodsTypeSecond\GoodsTypeSecondController');

    Route::apiResource('transport', 'Transport\TransportController');

    Route::apiResource('redpacket', 'RedPacket\RedPacketController');

    Route::get("get-self-redpacket","RedPacket\RedPacketController@getRedPacketWithUserid");

    Route::post("receive-red-packet","RedPacket\RedPacketController@ReceiveRedPacket");

    Route::post("delete-red-packet","RedPacket\RedPacketController@deleteRedPacketWithUserid");



    Route::apiResource('shoppingcart', 'ShoppingCart\ShoppingCartController');

    Route::apiResource('market', 'Market\MarketController');

    Route::post("market-money","Market\MarketController@money");

    Route::apiResource('frequently-question', 'HelpCenter\FrequentlyQuestionController');

    Route::apiResource('new-question', 'HelpCenter\NewQuestionController');


    Route::apiResource('banner', 'Banner\BannerController');

    Route::apiResource('data-statistics', 'DataStatistics\DataStatisticsController');

    Route::post('config/upload', 'Config\ConfigController@uploadGoodsImage');

    Route::post('config/send-sms', 'Config\ConfigController@sendSMSCode');

});
});