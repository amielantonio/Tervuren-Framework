<?php

class Kernel {

    /**
     * Run the kernel class
     */
    public static function run()
    {
        static::runRouters();
    }


    protected static function runRouters()
    {
        require_once S_BASEPATH . "/routes/web.php";
        Router::create();
    }

}
