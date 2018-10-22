<?php

namespace App\Helpers;

class View {



    public function render( $view, $data = [] )
    {
        extract( $data );

        return require S_VIEWPATH . "/{$view}.view.php";
    }

}
