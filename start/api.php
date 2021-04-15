<?php

/*
|--------------------------------------------------------------------------
| Web API
|--------------------------------------------------------------------------
|
| Here is where you can register your web api gateways that are
| connected to your ajax requests.
|
*/
//Web::register('post','awc/v1','course', 'MainController@index');

Web::resource('awc/v1','course','MainAjax');
Web::ajax('add_to_cart', 'MainAjax@add_to_cart');