<?php

class SharedData {

    protected static $storedData = [];

    protected static $instance;


    public static function share( $data )
    {

    }


    public static function getAll()
    {
        return static::$storedData;
    }

    public static function get( $key )
    {
        return static::$storedData[$key];
    }



    public static function instance()
    {
        if( is_null( static::$instance )){
            static::$instance = new static();
        }
        return static::$instance;
    }

    public static function clean()
    {
        static::$storedData = [];
    }



}
