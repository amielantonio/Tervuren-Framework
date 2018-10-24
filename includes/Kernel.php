<?php

use App\Controller\MainController;

class Kernel {

    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'create_pages' ) );
    }

    public function run()
    {
//        wp_enqueue_script( 'msq-bulma', 'https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.css');
//
//        wp_enqueue_style( 'msq-datatables', '//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' );
//        wp_enqueue_script( 'msq-datatables', '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js' );
//
//        wp_enqueue_script( 'msq-chart', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js' );

    }


    public function create_pages()
    {

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

}
