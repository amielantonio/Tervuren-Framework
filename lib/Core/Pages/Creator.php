<?php

class Creator {



    public function create( $name, $controller, $settings )
    {
        add_menu_page(
            __( "Strataplan Form Manager", "textdomain" ),
            __( "Strataplan Form Manager", "textdomain" ),
            "manage_options",
            "strataplan-form-manager",
            function(){ echo "hello"; },
            "dashicons-image-filter",
            "2"
        );

    }
}
