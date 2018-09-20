<?php
namespace App\Database;

use App\Database\Builder\DataWrapper;

class Database extends DataWrapper {


    public function install(){

        require s_base_path."/database/schema/strataplan-form-data.php";

        $test = new \StrataplanFormData();

        $test->up();

    }

    public function uninstall(){

    }
}
