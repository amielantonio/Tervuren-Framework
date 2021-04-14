<?php

namespace App\Core\Ajax;

use App\Core\Request;


class Callback
{

    private $controller;

    private $method;

    private $nonce;

    private $request;

    private $verb;

    public function __construct($controller = null, $method = null, $verb = null, $request = [])
    {
        $this->controller = $controller;
        $this->method = $method;
        $this->verb = $verb;
        $this->request = $request;
    }

    /**
     *
     *
     * @param null $verb
     * @return mixed
     */
    public function rest($verb = null)
    {
        $controller = $this->controller;
        $method = $this->method;
        $verb = ($verb != null) ? $verb : $this->verb;
        $verb = ucwords($verb);
        $do = "do".$verb;


        return $this->$do($controller, $method);
    }

    public function is_get()
    {

    }


    public function doPost($controller, $method)
    {
        if($this->request['REQUEST_METHOD'] !== 'POST'){
            echo json_encode([
                'error' => "request method used is {$this->request['REQUEST_METHOD']}, must be POST"
            ]);
            die();
        }

        /* TODO
         * add nonce validation
         * add middleware
         *
         */

        $request = new Request($_POST);

        return $controller->$method($request);
    }

    public function doGet($controller, $method)
    {
        return $controller->$method();
    }

    public function doDelete($controller, $method)
    {
        if($this->request['REQUEST_METHOD'] !== 'POST'){
            echo json_encode([
                'error' => "request method used is {$this->request['REQUEST_METHOD']}, must be POST"
            ]);
            die();
        }

        /* TODO
         * add nonce validation
         * add middleware
         *
         */

        $request = new Request($_POST);

        return $controller->$method($request);
    }

    public function doUpdate($controller, $method)
    {
        if($this->request['REQUEST_METHOD'] !== 'POST'){
            echo json_encode([
                'error' => "request method used is {$this->request['REQUEST_METHOD']}, must be POST"
            ]);
            die();
        }

        /* TODO
         * add nonce validation
         * add middleware
         *
         */

        $request = new Request($_POST);

        return $controller->$method($request);
    }


    public function is_post()
    {

    }

    public function is_delete()
    {

    }

    /**
     * Gets the method
     *
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Sets the method
     *
     * @param $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Gets the controller
     *
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Sets the controller
     *
     * @param $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * Get the controller method;
     *
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Sets the controller Method
     *
     * @param $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function getVerb()
    {
        return $this->verb;
    }

    public function setVerb($verb)
    {
        $this->verb = $verb;
    }


}