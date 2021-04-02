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
Router::addMenu('Test', 'MainController@index' );
Router::addSubMenu('Test', 'TheSubmenu', 'MainController@access_form');

Router::addChannel( 'post', 'MainController@test', 'test' );
Router::addChannel( 'post', 'MainController@index', 'test2' );


Router::woocommerce('tabs', 'AWC Course Settings', 'TabController', ['product_type' => 'variable']);

Router::woocommerce('settings', 'Custom', 'WooSettingsController');
