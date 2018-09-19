<?php
namespace App\Main;

use App\Controller\MainController;
class Main{

    private static $instance;

    public function __construct(){

        add_action( 'admin_menu', array($this, 'create_pages') );

    }

    /**
     *
     *
     * @return Main
     */
    public static function getInstance(){
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Create pages that are under the admin sidebar
     */
    public function create_pages(){


        $mainController = new MainController;

        if( !current_user_can( 'manage_strata_forms' ) ){

            add_menu_page(
                __( "Strataplan Form Manager", "textdomain" ),
                __( "Strataplan Form Manager", "textdomain" ),
                "manage_options",
                "strataplan-form-manager",
                array( $mainController, "index" ),
                "dashicons-image-filter",
                "2"
            );


            add_submenu_page(
                "strataplan-form-manager",
                __( "Access Device Form", "textdomain" ),
                __( "Access Device Form", "textdomain" ),
                "manage_options",
                "access-device-form",
                array( $mainController, "access_form" )
            );

            add_submenu_page(
                "strataplan-form-manager",
                __( "Move In/Out Form", "textdomain" ),
                __( "Move In/Out Form", "textdomain" ),
                "manage_options",
                "move-in-out-form1",
                array( $mainController, "move_form" )
            );

            add_submenu_page(
                "strataplan-form-manager",
                __( "Move In/Out Form", "textdomain" ),
                __( "Acquisition", "textdomain" ),
                "manage_options",
                "move-in-out-form2",
                array( $mainController, "move_form" )
            );

            add_submenu_page(
                "strataplan-form-manager",
                __( "Move In/Out Form", "textdomain" ),
                __( "Customers", "textdomain" ),
                "manage_options",
                "move-in-out-form3",
                array( $mainController, "move_form" )
            );

            add_submenu_page(
                "strataplan-form-manager",
                __( "Move In/Out Form", "textdomain" ),
                __( "Settings", "textdomain" ),
                "manage_options",
                "move-in-out-form4",
                array( $mainController, "move_form" )
            );

        }
    }

    public function start(){

    }
}
