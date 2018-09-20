<?php
namespace App\Database;

use Closure;
use App\Database\Grammar\Blueprint;

class Schema {


    public function install(){

    }


    public static function create( $table, Closure $callback ){

        //Blueprint returns an SQL
        //Format SQL
        //Run SQL

        $table = new Blueprint($table);

        $test = $callback($table);

        echo $test->integer( 'test' );

    }

}
