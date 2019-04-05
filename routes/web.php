<?php

Router::addMenu('Test', 'MainController@index' );
Router::addSubMenu('Test', 'TheSubmenu', 'MainController@access_form');

Router::addChannel( 'post', 'MainController@test', 'test' );
Router::addChannel( 'post', 'MainController@index', 'test2' );
