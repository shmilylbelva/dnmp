<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------



Route::get('api/:v/banner/:id', 'api/:v.Banner/getBanner')->pattern(['v' => 'v[1-2]']);

Route::group('api/:v/theme',function(){
    Route::get('', 'api/:v.Theme/getSimpleList');
    Route::get('/:id', 'api/:v.Theme/getComplexOne');
});

Route::group('api/:v/product',function(){
    Route::get('/recent', 'api/:v.Product/getRecent');//上新
    Route::get('/:id', 'api/:v.Product/detail')->pattern(['id' => '\d+']);//分类下的商品
});

Route::group('api/:v/category',function(){
    Route::get('', 'api/:v.Category/getCategories');
    Route::get('/:id', 'api/:v.Product/getAllInCategory');//分类下的商品
});


Route::post('api/:v/token/user', 'api/:v.Token/getToken');//获取code
Route::post('api/:v/address', 'api/:v.Address/saveAddress')->middleware(['Scope']);//获取code

Route::post('api/:v/order', 'api/:v.Order/placeOrder')->middleware(['ExclusiveScope']);//下单
Route::post('api/:v/order/by_user', 'api/:v.Order/getSummaryByUser')->middleware(['Scope']);//下单
Route::post('api/:v/order/:id', 'api/:v.Order/getDetail')->pattern(['id' => '\d+'])->middleware(['Scope']);//下单


Route::post('api/:v/pay/pre_order', 'api/:v.Pay/getPreOrder');//
Route::post('api/:v/pay/notify', 'api/:v.Pay/receiveNotify');//
Route::post('api/:v/pay/re_notify', 'api/:v.Pay/redirectNotify');//