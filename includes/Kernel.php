<?php

use App\Core\Router;
use App\Controller\MainController;

class Kernel {

    protected static $router;

    /**
     * Kernel constructor.
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'create_pages' ) );

        $this::$router = new Router;

        $this::$router->channel( 'stm-route' );

    }

    /**
     * Run the kernel class
     */
    public function run()
    {
        wp_enqueue_script( 'stm-bulma', 'https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.css');

        wp_enqueue_style( 'stm-datatables', '//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' );
        wp_enqueue_script( 'stm-datatables', '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js' );

        wp_enqueue_script( 'stm-chart', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js' );

        wp_enqueue_script( 'stm-app',  '/wp-content/plugins/strataplan-form-manager/assets/js/app.js');
        wp_enqueue_style( 'stm-app', '/wp-content/plugins/strataplan-form-manager/assets/css/app.css');
    }

    /**s
     * Create the starting pages
     */
    public function create_pages()
    {
        $mainController = new MainController;

        $this::$router->setController( $mainController );

        if( !current_user_can( 'manage_strata_forms' ) ){

//            add_menu_page(
//                __( "Strataplan Form Manager", "textdomain" ),
//                __( "Strataplan Form Manager", "textdomain" ),
//                "manage_options",
//                "strataplan-form-manager",
//                array( $this::$router, 'index' ),
//                "dashicons-image-filter",
//                "2"
//            );


//            add_submenu_page(
//                "strataplan-form-manager",
//                __( "Access Device Form", "textdomain" ),
//                __( "Access Device Form", "textdomain" ),
//                "manage_options",
//                "access-device-form",
//                array( $this::$router, "access_form" )
//            );
//
//            add_submenu_page(
//                "strataplan-form-manager",
//                __( "Move In/Out Form", "textdomain" ),
//                __( "Move In/Out Form", "textdomain" ),
//                "manage_options",
//                "move-in-out-form1",
//                array( $this::$router, "move_form" )
//            );
//
//            add_submenu_page(
//                "strataplan-form-manager",
//                __( "Move In/Out Form", "textdomain" ),
//                __( "Acquisition", "textdomain" ),
//                "manage_options",
//                "move-in-out-form2",
//                array( $this::$router, "move_form" )
//            );
//
//            add_submenu_page(
//                "strataplan-form-manager",
//                __( "Move In/Out Form", "textdomain" ),
//                __( "Customers", "textdomain" ),
//                "manage_options",
//                "move-in-out-form3",
//                array( $this::$router, "move_form" )
//            );
//
//            add_submenu_page(
//                "strataplan-form-manager",
//                __( "Move In/Out Form", "textdomain" ),
//                __( "Settings", "textdomain" ),
//                "manage_options",
//                "move-in-out-form4",
//                array( $this::$router, "move_form" )
//            );
        }


//        if( ! current_user_can( 'strataplan_developer' )){
//
//            add_menu_page(
//                __( "Strataplan Developer Options", "textdomain" ),
//                __( "Strataplan Form Manager", "textdomain" ),
//                "manage_options",
//                "strataplan-developer-options",
//                array( $this::$router, 'index' ),
//                "dashicons-shield",
//                "2"
//            );
//
//        }


    }

}
