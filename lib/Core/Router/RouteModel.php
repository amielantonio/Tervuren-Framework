<?php

class RouteModel {


    /**
     * Instance.
     *
     * @var RouteModel
     */
    protected static $instance;

    /**
     * Check for RouteModel Instance
     *
     * @return RouteModel
     */
    public static function instance()
    {
        //Check for Instance
        if( self::$instance === null ) {
            return self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Binds the parameter to the method
     *
     * @param $controller
     * @param $method
     * @return mixed
     * @throws ReflectionException
     */
    public static function bind( $controller, $method )
    {
        $args = [];
        $class = new $controller;
        $params = static::instance()->getParams( $class, $method );

        // We will loop in all parameters of the method here; checking all
        // parameters if it is a request class, a model class, or a simple
        // variable.
        foreach( $params as $param ){
            // We will check first if the method is a request method,
            // since the request method accepts a different parameters than
            // a model class, we need to segregate it to pass the proper
            // arguments
            if( static::instance()->is_request($param['class']) ){
                $requestedClass = "\\".$param['class'];
                $args[] = (new $requestedClass($_POST, $_GET, $_FILES));

            // This is where we bind the model class. Since we only bind
            // the Request class and the Model Class, we can process now
            // the arguments needed.
            } else if (static::instance()->is_model( $param['class'])) {
                $requestedClass = "\\".$param['class'];
                $modelClass = new $requestedClass;
                $modelClass->find($_GET[$param['method']]);

                $args[] = $modelClass;

            } else {
                $args[] = $_GET[$param['method']];
            }
        }

        // return the parameters with arguments
        return call_user_func_array( array($class, $method), $args);
    }

    /**
     * Get the parameters of $methods of $class.
     *
     * @param $class
     * @param $method
     * @return array
     * @throws ReflectionException
     */
    protected function getParams( $class, $method )
    {
        $collection = [];
        $reflection = new ReflectionMethod($class, $method);

        $params = $reflection->getParameters();

        foreach($params as $param){
            $collection[] = [
                'method' => $param->getName(),
                'class' => $param->getClass()->name,
            ];
        }

        return $collection;
    }

    protected function is_request($class)
    {
        return $class == "AWC\Core\Request";
    }

    protected function is_model( $class )
    {
        return ! is_null($class);
    }
}
