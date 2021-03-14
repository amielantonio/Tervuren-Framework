<?php
namespace App\Http\Controller;

use App\Helpers\Func;
use App\Helpers\View;
use App\Core\Request;
use App\Core\CoreController;
use App\Model\AccessDevice;
use CourseACFIntegration;

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
        CourseACFIntegration::init();
        CourseACFIntegration::getFieldById(136596);


        return ( new View( 'dashboard/dashboard') )->render();
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

    public function test( Request $request, AccessDevice $accessDevice )
    {
       var_dump($request);
    }
}
