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

        $devs = $device->select( ['1', '2'] )
//            ->where( 'test','1' )
//            ->where( [['test2' =>  'yes'],['test3' => 'no']] )
//            ->where( ['test4' => 'yesno'] )
            ->whereIn( 'type', ['yow', 'yes'] )
            ->orWhereIn( 'type', ['yow', 'yes'] )
//            ->where( 'test5','<','test5' )
            ->get();


        var_dump( $devs );

        return ( new View( 'dashboard/dashboard' ) )->render();
    }

    /**
     *
     *
     * @return mixed
     * @throws \exception
     */
    public function access_form()
    {
        return ( new View( 'access_device_form/access_device' ) )->render();
    }

    /**
     *
     *
     * @return mixed
     * @throws \exception
     */
    public function move_form()
    {
        return ( new View( 'move_in_out_form/move_form' ) )->render();

    }

    public function test()
    {
        echo "Did i reached this part?";
    }


}
