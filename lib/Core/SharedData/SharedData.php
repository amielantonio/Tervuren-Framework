<?php

class SharedData {

    protected static $storedData = [];

    protected static $instance;


    public static function share( $data )
    {
        static::storeData( $data );
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


    protected static function storeData( Array $data )
    {
        foreach( $data as $key => $value ){
            if( is_numeric( $key )){
                static::searchAndReplace( $value, $value );
            }
            else {
                static::searchAndReplace( $key, $value );
            }
        }
    }

    protected static function has( $key )
    {
        var_dump(static::$storedData );
        return in_array( $key, static::$storedData );
    }

    protected static function searchAndReplace( $key, $value )
    {
        if( static::has($key) ){
            static::$storedData[$key] = $value;
        } else {
            static::$storedData = array_merge(static::$storedData, [$key => $value] );
        }
    }
}
