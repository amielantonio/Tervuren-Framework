<?php

namespace AWC\Helpers;

use AWC\Database\Database;

class Installer{

    protected static $pipe = [];

    /**
     * Installation that is hooked with wordpress plugin activation
     */
    public function install()
    {
        register_activation_hook( S_BASEPATH.'/one-click-course-creation.php', array( $this, 'boot') );
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
//        ( new Database() )->install();

        //Run the Queue pipe!
        static::install_pipe();
    }

    /**
     * Register the class
     *
     * @param $class::Class
     * @param $method
     */
    public static function pipe( $class, $method )
    {
        static::$pipe[] = [
            'class' => $class,
            'method'=> $method
        ];
    }

    /**
     * Install all the class that are inside the pipe
     */
    public static function install_pipe()
    {
        foreach( static::$pipe as $pipe ){
            ( new $pipe['class'] )->$pipe['method'];
        }
    }



}
