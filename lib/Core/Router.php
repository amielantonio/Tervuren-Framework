<?php
namespace App\Core;

class Router {

    /**
     * Store the channel to the router
     *
     * @var string
     */
    protected $channel;

    /**
     * Controller being called by the router specified in the channel
     *
     * @var
     */
    protected $controller;

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
     * Sends the received routing to the appropriate controller
     *
     * @param $controller
     * @param $method
     */
    public function to( $controller, $method )
    {
        //Check first whether there is a channel that's being listened,
        // if there is none, continue calling the method of the controller
        if( $this->channel == "" ){

            ( new $controller )->$method();

        } else {

            $routes = explode( '-', $this->channel );

            $controller = str_replace( '/', '\\', $routes[0]);
            $method = $routes[1];

            $controller = "\App\\Controller\\{$controller}";

            ( new $controller )->$method();

        }
    }

    /**
     * Magic method for calling controller methods
     *
     * @param $name
     * @param $arguments
     */
    public function __call( $name, $arguments )
    {
        //Only send the command when the method doesn't exists on the class
        if( ! method_exists( $this, $name ) ){
            $this->to( $this->controller, $name );
        }
    }
}
