<?php
namespace App\Controller;

use App\Database\Database;
use App\Database\Schema;
use App\Database\SQL\Blueprint;

class MainController {

    /**
     * Landing Page
     *
     * @return mixed
     * @throws \exception
     */
    public function index()
    {
        $testdata = (new Blueprint( 'demo', function( Blueprint $blueprint ){
            $blueprint->create();

            $blueprint->integer( 'c_demo' );
            $blueprint->string( 'c_string_demo', 10 );
            $blueprint->primary(['id', 'c_demo']);
        }));

//
//        foreach( $testdata->getColumns() as $key => $value ){
//            foreach($value as $db_key => $db_value){
//
//                echo 'key: '.$db_key. '| value:' . '\''.$db_value.'\'' .  '<br />';
//
//            }
//        }
//
//        foreach( $testdata->getColumns() as $key => $value ){
//            echo implode(", ",$value);
//        }




//        $testdata = array_merge( $testdata->getColumns() );



//        print_r( array_shift($testdata) );


        return view( 'dashboard/dashboard', compact( 'testdata' ) );
    }

    /**
     *
     *
     * @return mixed
     * @throws \exception
     */
    public function access_form()
    {
        return view( 'access_device_form/access_device' );
    }

    /**
     *
     *
     * @return mixed
     * @throws \exception
     */
    public function move_form()
    {
        return view( 'move_in_out_form/move_form' );

    }

}
