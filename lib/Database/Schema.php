<?php
namespace App\Database;

use Closure;
use App\Database\SQL\Blueprint;

/**
 *
 *
 * Class Schema
 * @package App\Database
 */
class Schema {

    public static function create( $table, Closure $callback )
    {

        //Blueprint returns an SQL
        //Format SQL
        //Run SQL

        $blueprint = new Blueprint( $table );

//        $callback( $blueprint );


    }

    public static function droptable( $table )
    {

    }

    public function build()
    {

    }

    public function tap()
    {

    }

}
