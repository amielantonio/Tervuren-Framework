<?php
namespace App\Controller;

use App\Database\Database;

//Testing main controller
use App\Database\SQL\Blueprint;

class MainController{

    /**
     * Landing Page
     *
     * @return mixed
     * @throws \exception
     */
    public function index(){


        $testdata = (new Blueprint( 'demo', function( Blueprint $blueprint ){

            $blueprint->integer( 'c_demo' )->unique();
            $blueprint->string( 'c_string_demo', 10 );
            $blueprint->primary(['id', 'c_demo']);
        }));

        $testdata = $testdata->getCommands();


        return view( 'dashboard/dashboard', compact( 'testdata' ) );

    }

    /**
     *
     *
     * @return mixed
     * @throws \exception
     */
    public function access_form(){

        return view( 'access_device_form/access_device' );

    }

    /**
     *
     *
     * @return mixed
     * @throws \exception
     */
    public function move_form(){

        return view( 'move_in_out_form/move_form' );

    }

}
