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
Route::get('api/:v/theme', 'api/:v.Theme/getSimpleList');
Route::get('api/:v/theme/:id', 'api/:v.Theme/getComplexOne');
Route::get('api/:v/product', 'api/:v.Product/getRecent');//上新
Route::get('api/:v/category', 'api/:v.Category/getCategories');
Route::get('api/:v/category/:id', 'api/:v.Product/getAllInCategory');//分类下的商品
Route::post('api/:v/token/user', 'api/:v.Token/getToken');//获取code
