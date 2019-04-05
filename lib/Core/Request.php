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

        $this->currentPage = $post['page'];

        $this->currentRoute = $post['route'];
    }

    public function method()
    {

    }

    public function has( $key )
    {

    }

    public function is()
    {

    }

    public function input( $key, $default = null )
    {

    }

    public function file()
    {

    }

    public function all()
    {

    }

    public function isMethod()
    {

    }

    public function query()
    {

    }

    public function toArray()
    {

    }

    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

}
