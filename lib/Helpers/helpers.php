<?php
if( ! function_exists( 'view' )){

    /**
     * Get the view that was specified
     *
     * @param $view
     * @param array $data
     * @return mixed
     * @throws exception
     */
    function view( $view, $data = [] ){

        if( !file_exists( s_temp_path."/{$view}.view.php" )){
            throw new exception( 'No View' );
        }

        extract( $data );

        return require s_temp_path."/{$view}.view.php";

    }

}


if( ! function_exists( 'route' ) ){

    function route(){



    }

}
