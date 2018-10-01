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
        $testdata = (new Blueprint( 'demo', function( Blueprint $blueprint ){
            $blueprint->create();

            $blueprint->integer( 'c_demo' );
            $blueprint->string( 'c_string_demo', 10 );
            $blueprint->primary(['id', 'c_demo']);
        }));

        $sql = new SQLize( $testdata );

        $testdata = $sql->toSQL();

        return view( 'dashboard/dashboard', compact( 'testdata' ) );
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
