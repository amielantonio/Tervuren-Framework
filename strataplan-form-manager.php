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

require_once 'vendor/autoload.php';
use App\Main\Main;
//use App\Database\Schema;
//use App\Database\Seeds;


define( 's_base_path', dirname( __FILE__ ) );
define( 's_assets_path', dirname(__FILE__) . "/assets" );
define( 's_lib_path', dirname( __FILE__)."/lib" );
define( 's_temp_path', dirname( __FILE__)."/templates" );
define( 's_db_path', dirname( __FILE__)."/database" );

//
require "lib/Helpers/helpers.php";


register_activation_hook( __FILE__, 'strata_activation');
function strata_activation(){

//    $schema = require "lib/Database/Schema.php";
//    $seeds = require "lib/Database/Seeds.php";
//
//
//    $schema->install();
//    $seeds->install();

}

add_action( 'init', 'strata_init' );
function strata_init(){

    do_action( 'strata_init' );

    $app = new Main();

    //Start the Plugin
    $app->start();
}


function strata_role(){

}

function strata_capability(){

}
