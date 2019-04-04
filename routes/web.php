<?php

Router::addMenu('Test', 'MainController@index', [ 'capability'=>'manage_options' ]);
Router::addSubMenu('Test', 'TheSubmenu', 'MainController@access_form');

Router::addChannel( 'post', 'MainController@test', 'test' );
Router::addChannel( 'post', 'MainController@test2', 'test2' );
