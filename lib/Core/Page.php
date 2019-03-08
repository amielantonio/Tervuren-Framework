<?php

namespace App\Core;

use Closure;
use App\Helpers\Arr;

class Page {

    /**
     * @var array
     */
    protected static $actions = [];



    public static function set( $location, $action, $settings )
    {
        if( $action instanceof Closure){
            call_user_func( $action );
        }

        if( is_array( $action )){

        }

        self::$actions[] = compact( 'location', 'action', 'settings' );

//        return self::instance();

    }

    protected function instance()
    {
        return $this;
    }

    protected function bindAction( $location, $action, $settings )
    {

    }

    protected function getBinding( $key )
    {

    }

    public static function getActions()
    {
        return self::$actions;
    }

    public function createPages()
    {

    }

    protected function createPage()
    {

    }

    protected function identifyPageLocation()
    {

    }

    public function name()
    {

    }


}
