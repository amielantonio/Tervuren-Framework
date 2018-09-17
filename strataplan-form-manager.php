<?php
/**
 * Plugin Name: Strataplan From Manager
 * Plugin URI: http://yourvirtualpeople.com.au
 * Description: Lorem ipsum dolor sit amet
 * Author: Amiel Antonio
 * Version 1.0.0
 * Text Domain: strataplan-form-manager
 *
 * @package Strataplan_Form_Manager
 */


if( ! defined( 'WPINC' ) ) die;


define( 's_base_path', dirname( __FILE__ ) );
define( 's_assets_path', dirname(__FILE__) . "/assets" );
define( 's_lib_path', dirname( __FILE__)."/lib" );
define( 's_temp_path', dirname( __FILE__)."/temp" );
define( 's_db_path', dirname( __FILE__)."/database" );




function strata_activation(){

    $schema = require "lib/Database/Schema.php";
    $seeds = require "lib/Database/Seeds.php";


    $schema->install();
    $seeds->install();

}


function strata_init(){



}


function strata_role(){

}

function strata_capability(){

}
