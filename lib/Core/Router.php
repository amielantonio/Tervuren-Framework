<?php
namespace App\Core;

class Router {

    /**
     * Store the channel to the router
     *
     * @var string
     */
    protected $channel;

    protected $controller;

    /**
     * Router constructor.
     *
     * use the given variable as the main router variable
     */
    public function __construct()
    {

    }

    /**
     * Listens to the router instance and the send it to the controller
     *
     * @param $channel
     * @return $this|bool
     */
    public function channel( $channel = "" )
    {
        if( isset( $_GET[ $channel ] ) && $channel <> "" ){
            $this->channel = urldecode( $_GET[ $channel ] );
        }

        return $this;
    }

    /**
     * Set the controller of the router
     *
     * @param $controller
     */
    public function setController( $controller )
    {
        $this->controller = $controller;
    }


    /**
     * Sends the received routing to the controller
     *
     * @param $controller
     * @param $method
     */
    public function to( $controller, $method )
    {
        if( $this->channel == "" ){
            (new $controller)->$method();

        }else{

            $controller = $this->invoke();

        }
    }


    protected function invoke()
    {
        $app = "\App\\Controller\\";
        $dir = str_replace( '/', '\\', $this->controller);
        return $app . $dir;
    }

    /**
     * Magic method for calling controller methods
     *
     * @param $name
     * @param $arguments
     */
    public function __call( $name, $arguments )
    {
        $this->to( $this->controller, $name );
    }
}
