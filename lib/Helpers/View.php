<?php

namespace App\Helpers;

class View {

    /**
     * View name
     *
     * @var $view
     */
    protected $view;

    /**
     *
     *
     * @var string
     */
    protected $path;

    /**
     * Data attributed with the view
     *
     * @var array
     */
    protected $data;

    public function __construct( $view, $data = [] )
    {
        $this->view = $view;
        $this->data = $data;

        $this->path = S_VIEWPATH . "{$this->view}.view.php";
    }

    /**
     * @return mixed|string
     */
    public function render()
    {
        if( ! $this->exists() ){
            return "";
        }

        extract( $this->data );

        return require $this->path;
    }


    public function addScript( $scripts = [] )
    {
        // accepted variables
        // handle
        // src
        // deps
        // version
        // in-footer
    }

    /**
     * @param array $styles
     * @throws \exception
     */
    public function addStyles( $styles = [] )
    {
        // accepted variables
        // handle
        // src
        // deps
        // version
        // media

    }

    public function exists()
    {
        return ( file_exists( $this->path ) );
    }

    /**
     * Include data on form
     *
     * @param mixed ...$data
     * @return $this
     */
    public function with( ...$data ){
        $this->data = $data;

        return $this;
    }

}
