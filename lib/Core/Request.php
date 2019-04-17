<?php

namespace App\Core;

use ArrayAccess;
use App\Helpers\Contracts\Arrayable;

class Request implements Arrayable, ArrayAccess {

    /**
     * @var
     */
    protected $currentPage;

    /**
     * @var
     */
    protected $currentRoute;

    protected $post = [];

    protected $get = [];

    protected $file = [];

    public function __construct( $post = [], $get = [], $file = [] )
    {
        $this->post = $post;

        $this->currentPage = $get['page'];

        $this->currentRoute = $get['route'];
    }

    public function method()
    {

    }

    public function has( $key )
    {
        return array_key_exists( $key, $this->post);
    }

    public function is()
    {

    }

    /**
     *
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

    public function file()
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
