<?php
namespace App\Database;

use Closure;
use App\Database\SQL\Blueprint;

class Schema {

    public static function create( $table, Closure $callback )
    {

        //Blueprint returns an SQL
        //Format SQL
        //Run SQL

        $blueprint = new Blueprint( $table );

//        $callback( $blueprint );


    }


    public static function drop( $table )
    {

    }

    public function build()
    {

    }

}
