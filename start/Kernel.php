<?php

class Kernel {

    /**
     * Run the kernel class
     */
    public static function run()
    {
        static::runRouters();
        static::runAjax();
    }

    protected static function runRouters()
    {
        require_once S_BASEPATH . "/start/web.php";
        Router::run();
    }

    protected static function runScripts()
    {

    }

    protected static function runAjax()
    {
        require_once S_BASEPATH . "/start/api.php";
        echo "labyu";
        Web::run();

    }

}
