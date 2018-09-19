<?php
namespace App\Controller;

class MainController{

    /**
     *
     *
     * @return mixed
     * @throws \exception
     */
    public function index(){


        $testdata = "This is a test";

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
