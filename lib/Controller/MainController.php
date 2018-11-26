<?php
namespace App\Controller;

use App\Helpers\Func;
use App\Helpers\View;
use App\Core\CoreController;
use App\Model\AccessDevice;
use GuzzleHttp\Client;

class MainController extends CoreController{


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Landing Page
     *
     * @return mixed
     * @throws \exception
     */
    public function index()
    {
        $device = new AccessDevice;

        $device->test = "Yes";

        var_dump( $device );


        return (new View('dashboard/dashboard', compact( 'device' )))->render();
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

    public function test()
    {
        echo "Did i reached this part?";
    }


}
