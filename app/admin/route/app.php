<?php

use think\facade\Route;

Route::group('/', function () {
    Route::get('admin/index', 'index/index');
});