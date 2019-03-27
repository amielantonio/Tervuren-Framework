<?php
namespace App\Controller;

use App\Helpers\Func;
use App\Helpers\View;
use App\Core\CoreController;

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
//        return ( new View( 'dashboard/dashboard', ["testKey"=>'Julz Panget'] ) )->render();
        return ( new View( 'dashboard/dashboard') )
            ->with( 'testKey', '' )
            ->with( 'testKey2', 'testVal2' )->render();
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
