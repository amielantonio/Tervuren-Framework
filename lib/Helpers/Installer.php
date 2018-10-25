<?php

namespace App\Helpers;

use App\Database\Database;

class Installer{

    protected $pipe = [];

    /**
     * Installation that is hooked with wordpress plugin activation
     */
    public function install()
    {
        register_activation_hook( __FILE__, array( $this, 'boot') );
    }

    /**
     * Uninstalling the plugin hook.
     */
    public function uninstall()
    {
        register_deactivation_hook( __FILE__, array($this, '' ) );
    }

    /**
     * Run installation sequence here.
     */
    public function boot()
    {
        //Install all things that are needed to be installed first.
        ( new Database )->install();

        //Run the Queue pipe!
        $this->install_pipe();

    }

    /**
     * Register the class
     *
     * @param $class::Class
     * @param $method
     */
    public function pipe( $class, $method )
    {
        $this->pipe[] = [
            'class' => $class,
            'method'=> $method
        ];
    }

    /**
     * Install all the class that are inside the pipe
     */
    public function install_pipe()
    {
        foreach( $this->pipe as $pipe ){
            ( new $pipe['class'] )->$pipe['method'];
        }
    }



}
