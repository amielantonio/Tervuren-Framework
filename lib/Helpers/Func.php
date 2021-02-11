<?php

namespace AWC\Helpers;

use Closure;

class Func {

    public function value( $value ){

        return $value instanceof Closure ? $value() : $value;

    }

    public function config( $key, $default = "" )
    {

    }

    public function call( $value, $callback )
    {
        $callback( $value );

        return $value;
    }

}
