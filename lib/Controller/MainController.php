<?php
namespace App\Controller;

use App\Database\Database;
use App\Database\Schema;
use App\Database\SQL\Blueprint;
use App\Database\SQL\SQLize;
use App\Database\SQL\Helpers\Column;

class MainController {

    /**
     * Landing Page
     *
     * @return mixed
     * @throws \exception
     */
    public function index()
    {
        return view( 'dashboard/dashboard' );
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
