<?php
namespace App\Core;

use App\Database\Builder\DataWrapper;

abstract class CoreModel extends DataWrapper{

    public function __construct()
    {

    }


    public function __get($name)
    {
        // TODO: Implement __get() method.
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
    }

}
