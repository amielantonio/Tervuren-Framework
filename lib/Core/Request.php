<?php

namespace App\Core;

use ArrayAccess;
use App\Helpers\Contracts\Arrayable;

class Request implements Arrayable, ArrayAccess {

    /**
     * @var
     */
    protected $requestPage;

    /**
     * @var
     */
    protected $requestRoute;

    protected $post = [];

    protected $get = [];

    protected $file = [];

    protected $all = [];

    public function __construct( $post = [], $get = [], $file = [] )
    {
        $this->post = $post;

        $this->get = $this->processGet($get);

        $this->requestPage = $get['page'];

        $this->requestRoute = $get['route'];

        $this->all = array_merge($this->post, $this->get);
    }

    public function method()
    {

    }

    /**
     * Check if the data has the data
     *
     * @param $key
     * @return bool
     */
    public function has( $key )
    {
        return array_key_exists( $key, $this->post);
    }

    /**
     *
     *
     * @param array $keys
     * @return bool
     */
    public function hasAny( $keys = [] )
    {
        if( is_array($keys) ){
            foreach( $keys as $key ) {
                return array_key_exists( $key, $this->post);
            }

        }

        return false;
    }


    public function is( $path )
    {
        return ( $path == $this->requestPage );
    }

    /**
     * get input from the requests
     *
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function input( $key, $default = null )
    {
        return ( $this->has($key) )
            ? $this->post[$key]
            : $default;
    }

    /**
     * Unset some GET requests
     *
     * @param $getRequest
     * @return mixed
     */
    public function processGet( $getRequest )
    {

        unset($getRequest['page']);
        unset($getRequest['route']);

        return $getRequest;

    }


    public function file()
    {

    }

    public function except()
    {

    }

    public function only()
    {

    }

    /**
     * Returns all request
     *
     * @return array
     */
    public function all()
    {
        return $this->post;
    }

    public function isMethod( $key, $method )
    {
        var_dump($_REQUEST);
    }

    public function page()
    {
        return $this->requestPage;
    }

    public function query()
    {

    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->all();
    }

    public function toJSON()
    {

    }

    public function getHeaders()
    {

    }

    public function userAgent()
    {

    }

    public function ip()
    {

    }

    public function route()
    {

    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
        return $this->__get($offset);
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    public function __isset($key)
    {

    }

    public function __get($key)
    {

    }

}
