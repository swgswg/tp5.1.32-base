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

/**
 *  :version 是版本号
 *  v1/signIn 表示v1版本的接口
 */

/**
 * 例子
    Route::group('api/:version/admin/',function (){
        Route::post('/index',  'api/:version.Admin/index');
    });
 */

Route::miss('api/v1.Miss/miss');