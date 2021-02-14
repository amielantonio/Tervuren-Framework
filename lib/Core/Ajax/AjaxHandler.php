<?php

namespace App\Core\Ajax;

abstract class AjaxHandler
{

    /**
     * Wordpress Nonce
     *
     * @var string
     */
    public $nonce="";

    public $name = "";

    public $script_url = "";

    public function register($name)
    {
        add_action('wp_loaded', array($this, 'register_script'));
    }


    public function method()
    {

    }

    public function registerScript()
    {

    }








}