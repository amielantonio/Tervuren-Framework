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

/**
 * Constants
 */
define( 's_base_path', dirname( __FILE__ ) );
define( 's_assets_path', dirname(__FILE__) . "/assets" );
define( 's_lib_path', dirname( __FILE__)."/lib" );
define( 's_temp_path', dirname( __FILE__)."/templates" );
define( 's_db_path', dirname( __FILE__)."/database" );

/*******************
 * Vendor Autoload *
 *******************
 *
 * Require Composer autoload file.
 */
require_once 'vendor/autoload.php';

use App\Main\Main;
use App\Database\Schema;
use App\Database\Seeds;

require "lib/Helpers/helpers.php";




function strata_activation(){


}

function strata_deactivation(){

}

register_activation_hook( __FILE__, 'strata_activation');
register_deactivation_hook( __FILE__, 'strata_deactivation');

add_action( 'init', 'strata_init' );
function strata_init(){

    do_action( 'strata_init' );

    $app = Main::getInstance();

    //Start the Plugin
    $app->start();
}


function strata_role(){

}

function strata_capability(){

}
