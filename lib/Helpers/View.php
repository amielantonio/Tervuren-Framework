<?php

namespace App\Helpers;

class View {


    protected $view;

    protected $path;

    protected $data;

    public function __construct()
    {

    }

    public function render( $view, $data = [] )
    {
        extract( $data );

        return require S_VIEWPATH . "/{$view}.view.php";
    }


    public function addScript( $scripts = [] )
    {

    }

    public function addStyles( $styles = [] )
    {

    }

    public function exists( $view )
    {

    }

    public function getContents( $view )
    {

    }

    public function with( ...$data ){

    }

}
