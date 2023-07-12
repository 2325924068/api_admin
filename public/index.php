<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2019 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
namespace think;
header('Content-Type:text/html;charset=utf-8');

// 检测PHP环境
if (version_compare(PHP_VERSION, '7.2.0', '<')) die('PHP版本过低，最少需要PHP7.2.0，请升级PHP版本！');

require __DIR__ . '/../vendor/autoload.php';

// 执行HTTP应用并响应
$http = (new App())->http;

// 检测程序安装
if (!is_file(__DIR__ . '/install.lock')) {
    $response = $http->name('install')->run();
//    $response = $http->run();
} else {
    $response = $http->run();
}

$response->send();

$http->end($response);
