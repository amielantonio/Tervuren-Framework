<?php
namespace App\Controller;

use App\Helpers\Func;
use App\Helpers\View;

class MainController {

    /**
     * Landing Page
     *
     * @return mixed
     * @throws \exception
     */
    public function index()
    {
        return (new View)->render( 'dashboard/dashboard' );
    }

    /**
     *
     *
     * @return mixed
     * @throws \exception
     */
    public function access_form()
    {
        return (new View)->render( 'access_device_form/access_device' );
    }

    /**
     *
     *
     * @return mixed
     * @throws \exception
     */
    public function move_form()
    {
        return (new View)->render( 'move_in_out_form/move_form' );

    }

}
