<?php
namespace App\Core;

use App\Database\Builder\DataWrapper;

abstract class CoreModel extends DataWrapper{


    protected  $fields = [];


    public function __construct()
    {

    }


    public function __get($name)
    {
        return $this->fields[ $name ];
    }

    public function __set($name, $value)
    {
        $this->fields[ $name ] = $value;
    }

}
