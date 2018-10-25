<?php
namespace App\Core;

class Router {

    /**
     * Store the given routing to the router
     *
     * @var string
     */
    protected $route;

    /**
     * Router constructor.
     *
     * use the given variable as the main router variable
     */
    public function __construct( $variable )
    {
        if( isset( $_GET[ $variable ] )){
            $this->route = urldecode( $_GET[ $variable ] );
        }
    }

    /**
     * Listens to the router instance and the send it to the controller
     *
     * @return bool
     */
    public function receiver()
    {
        if( $this->route == "" || $this->route == null ){
            return true;
        }

        $route = explode( '-', $this->route );

        $this->to( $route[0], $route[1] );

    }

    /**
     * Sends the received routing to the controller
     *
     * @param $controller
     * @param $method
     * @return bool
     */
    protected function to( $controller, $method )
    {
        $app = "\App\\Controller\\";
        $dir = str_replace( '/', '\\', $controller);
        $app = $app . $dir;

        ( new $app )->$method;
    }
}
