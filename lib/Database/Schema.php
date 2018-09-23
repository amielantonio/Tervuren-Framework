<?php
namespace App\Database;

use Closure;
use App\Database\Grammar\Blueprint;

class Schema {


    /**
     * install all database migration instances
     */
    public function install(){



    }


    public static function create( $table, Closure $callback ){

        //Blueprint returns an SQL
        //Format SQL
        //Run SQL

        echo "this should be the first";
        $callback( $table );

    }


    public static function drop( $table ){

    }

}
