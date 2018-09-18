<?php
namespace App\Controller;

class MainController{

    /**
     * @return mixed
     * @throws \exception
     */
    public function index(){

        return view( 'dashboard/dashboard' );

    }

}
