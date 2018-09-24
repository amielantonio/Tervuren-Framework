<?php

namespace App\Database\SQL;

/**
 * Used to format the blueprints sql
 *
 * Class SQLize
 * @package App\Database\SQL
 */
class SQLize{


    protected $sql = "";

    protected $attributes = [];


    public function __construct( $attributes = [] )
    {

        //Build SQL here
        //$this->sql = $this->buildSQL( $attributes );

        $this->attributes = $attributes;

    }

    public function format(){
        return $this->attributes;
    }

    public function createSQL(){

    }



}
