<?php

class Web {

    /**
     * For singleton Web file list
     *
     * @var Web
     */
    protected static $instance;

    /**
     * Contains all routing list that will be executed to create API gateways
     *
     * @var array
     */
    protected static $routeList = [];

    /**
     * Web Instance
     *
     * @return $this
     */
    protected function instance()
    {
        return $this;
    }

    /**
     * Use to register a Route to create a gateway
     *
     * @param $verb
     * @param $route
     * @param $ajax
     * @param array $settings
     */
    public static function register( $verb, $route, $ajax, $settings=[] )
    {
        //Check for Instance
        if( self::$instance === null ) {
            self::$instance = new self;
        }

        $function = ( $ajax instanceof Closure )
                    ? $ajax
                    : self::$instance->setController($ajax, $verb);

        self::$routeList[] = array_merge( compact('route', 'verb', 'function'), $settings);
    }

    public static function run()
    {

    }


    public static function create_gateway()
    {

    }

    public static function get($route, $ajax, $settings=[])
    {
        self::register('get', $route, $ajax, $settings);
    }

    public static function post($route, $ajax, $settings=[])
    {
        self::register('post', $route, $ajax, $settings);
    }

    public static function put($route, $ajax, $settings=[])
    {
        self::register('put', $route, $ajax, $settings);
    }

    public static function delete($route, $ajax, $settings=[])
    {
        self::register('delete', $route, $ajax, $settings);
    }

    public static function resource($route, $ajax, $settings=[])
    {

    }

    /**
     * Set the controller and method of the Rest API
     *
     * @param $controller
     * @param $verb
     * @return array
     */
    protected function setController( $controller, $verb )
    {
        if(strpos($controller, '@') !== false ){
            $method = explode('@', $controller);
            $control = [
                'controller' => $method[0],
                'method' => $method[1]
            ];
        } else {
            $control = [
                'controller'=> $controller,
                'method' => $verb
            ];
        }

        return $control;
    }

    /**
     * Get the array routing list that was registered
     *
     * @return array
     */
    public static function getList()
    {
        return self::$routeList;
    }
}