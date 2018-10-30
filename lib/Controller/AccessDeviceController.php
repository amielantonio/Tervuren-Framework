<?php
namespace App\Controller;

use App\Helpers\Func;
use App\Helpers\View;
use App\Core\CoreController;
use App\Model\AccessDevice;

class AccessDeviceController extends CoreController
{

    public function save(){

        $test = new AccessDevice();

        $test->test = "Test";

    }

}
