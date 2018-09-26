<?php
namespace App\Controller;

use App\Database\Database;

class MainController {

    /**
     * Landing Page
     *
     * @return mixed
     * @throws \exception
     */
    public function index()
    {

        return view( 'dashboard/dashboard', compact( '' ) );

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
