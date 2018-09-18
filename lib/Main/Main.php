<?php
namespace App\Main;

use App\Controller\MainController;
class Main{

    private static $instance;

    public function __construct(){

        add_action( 'admin_menu', array($this, 'create_pages') );

    }

    public static function getInstance(){
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self;
        }

        return self::$instance;
    }


    public function create_pages(){


        $mainController = new MainController;

        if( !current_user_can( 'manage_strata_forms' ) ){

            add_menu_page(
                __( "Title", "textdomain" ),
                __( "Strataplan Form Manager", "textdomain" ),
                "manage_options",
                "strataplan-form-manager",
                array($mainController, "index" ),
                "dashicons-image-filter",
                "2"
            );

        }


    }

    public function start(){

    }
}
