<?php

class AjaxFactory
{

    private $ajaxList = [];

    /**
     * Starts the creation and registration of the AJAX
     *
     * @param Web $web
     */
    public function create( Web $web)
    {
        foreach($web::$ajaxList as $ajax) {

            $method = $this->create_method($ajax['function']);

            add_action("wp_ajax_{$ajax['name']}", $method );

            if($ajax['nopriv']) {
                add_action("wp_ajax_nopriv_{$ajax['name']}", $method);
            }

        }
    }

    /**
     * @param $function
     * @return array | Closure
     */
    private function create_method( $function )
    {
        // Check whether the function submitted is a closure,
        // If it is then return the function passed as the
        // callback method
        if($function instanceof Closure)
        {
            return $function;
        }

        // If it reached this point, it means that the submitted
        // function is an array. The code will then assemble an
        // array format of the class and the method that will be
        // called.
        $path = "\\App\Http\API\\";

        $controller = $path.$function['controller'];
        $method = $function['method'];

        // Check if the request method is POST, so that we can bind
        // the Request class inside the method
        if($_SERVER['REQUEST_METHOD'] == "POST") {

            return function() use($controller, $method){
                $request = new \App\Core\Request($_POST);
                $controller = new $controller;

                return $controller->$method($request);
            };
        }

        //Return an array for a simple GET request
        return [ $controller, $method ];
    }


    private function bindData()
    {

    }




    
    
    

}
