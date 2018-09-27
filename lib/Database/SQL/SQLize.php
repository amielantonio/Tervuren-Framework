<?php

namespace App\Database\SQL;

/**
 * Used to format the blueprints sql
 *
 * Class SQLize
 * @package App\Database\SQL
 */
class SQLize{

    /**
     * Defines the current SQL
     *
     * @var string
     */
    protected $sql = "";

    /**
     * Defines the current attributes to be formatted
     *
     * @var array
     */
    protected $attributes = [];


    public function __construct( $attributes = [] )
    {

        //Build SQL here
        //$this->sql = $this->buildSQL( $attributes );

        $this->attributes = $attributes;

    }

    public function format()
    {
        return $this->attributes;
    }

    public function createSQL()
    {

    }

    public function toSQL()
    {
        return $this->sql;
    }



}
