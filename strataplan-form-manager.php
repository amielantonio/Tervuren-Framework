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


final class StrataplanFormManager {

    /**
     * Current's Plugin Version
     *
     * @var string
     */
    protected $version = "1.0.0";

    /**
     * Minimum required PHP version
     *
     * @var string
     */
    protected $php_version = '5.6';

    /**
     * Singleton instance for the plugin
     *
     * @var StrataplanFormManager
     */
    private static $instance;

    /**
     * Creates a single instance of the plugin
     *
     * @since 1.0.0
     * @return StrataplanFormManager
     */
    public static function init()
    {
        if( ! isset( self::$instance ) && !( self::$instance instanceof StrataplanFormManager) ){
            self::$instance = new StrataplanFormManager();
            self::$instance->start();
        }

        return self::$instance;
    }


    /**
     * Run Plugin Setup
     */
    private function start()
    {

        //Check if the current PHP version
        register_activation_hook( __FILE__, array( $this, 'auto_deactivate') );

        $this->define_constants();
        $this->registerAutoload();
        $this->load_dependencies();
        // Once all dependencies and services has been loaded, install database
        // and boot up the entire plugin
//
//        register_activation_hook( __FILE__, array( $this, 'activate') );
//        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        $this->boot();

    }

    /**
     * Define Class constants
     */
    private function define_constants()
    {
        //Libraries
        define( 'S_BASEPATH'    , dirname( __FILE__ ) );
        define( 'S_LIBPATH'     , dirname( __FILE__) . "/lib" );
        define( 'S_ASSETSPATH'  , dirname(__FILE__ ) . "/assets" );
        define( 'S_CONFIGPATH'  , dirname(__FILE__ ) . "/config" );
        define( 'S_DBPATH'      , dirname( __FILE__) . "/database" );
        define( 'S_INCPATH'     , dirname( __FILE__) . "/includes" );
        define( 'S_VIEWPATH'    , dirname( __FILE__) . "/templates" );


        //Misc
        define( 'S_VERSION', $this->version );
        define( 'S_PHP_VERSION', $this->php_version );
    }

    /**
     * Auto Deactivates the plugin when the PHP Version is lower than required,
     * Then show the error on the front end
     */
    private function auto_deactivate()
    {
        if( version_compare( PHP_VERSION, $this->php_version, '<=') ) {
            return;
        }

        deactivate_plugins( basename(__FILE__) );

        $error = "<h1>Plugin Activation Error</h1>";
        $error .= "<p>Required PHP Version: {$this->version}</p>";

        wp_die( $error, "Plugin Activation Error", array( 'response' => 200, 'back_link' => true ));
    }


    /**
     * Load all helper functions
     */
    private function registerAutoload()
    {
        //Require Vendor Autoload
        require_once 'vendor/autoload.php';
    }

    /**
     * Loads all dependencies
     */
    private function load_dependencies()
    {
        //Load dependency classes such as custom post types,
        //roles, databases and other wordpress instantiation before adding
        //it to any navigation.


//        ( new \App\Database\Database )->install();

    }

    private function boot()
    {
        require_once "includes/Kernel.php";

        (new Kernel)->run();
    }

}

/**
 * Start the App
 */
StrataplanFormManager::init();
