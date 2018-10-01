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
    function view( $view, $data = [] )
    {

        if( !file_exists( s_temp_path."/{$view}.view.php" )){
            throw new exception( 'No View' );
        }

        extract( $data );

        return require s_temp_path."/{$view}.view.php";

    }

}

if( ! function_exists( 'route' ) ){

    function route()
    {


    }

}

if( ! function_exists( 'call' )){

    /**
     * Call the given closure with the given value, then return the value
     *
     * @param $value
     * @param $callback
     * @return mixed
     */
    function call( $value, $callback )
    {
        $callback( $value );

        return $value;
    }

}


if (! function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}
