<?php

Router::addMenu('Test', 'MainController@index', [ 'capability'=>'manage_options' ]);
Router::addSubMenu('Test', 'TheSubmenu', 'MainController@access_form');
