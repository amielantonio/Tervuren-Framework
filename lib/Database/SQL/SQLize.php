<?php

namespace App\Database\SQL;

class SQLize{


    protected $sql = "";

    protected $attributes = [];


    public function __construct( $attributes = [] )
    {

    }


    public function toSQL()
    {

    }

    /**
     * return the SQL
     *
     * @return string
     */
    public function getSQL()
    {
        return $this->sql;
    }



}