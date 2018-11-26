<?php

namespace App\Helpers;

class View {


    protected $view;

    protected $path;

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

        $enqueue = [];

        foreach( $styles as $style ){

            if( ! isset( $style['handle'] ) ){
                $enqueue[] = $styles['handle'];
            }else{
                throw new \exception( 'No Handle Given' );
            }
            if( ! isset( $style['src'] ) ){
                $enqueue[] = $styles['src'];
            }else{
                throw new \exception( 'No URL Given' );
            }

            if( ! isset( $style['deps'] ) ){
                $enqueue[] = $styles['deps'];
            }
            if( ! isset( $style['version'] ) ){
                $enqueue[] = $styles['version'];
            }
            if( ! isset( $style['handle'] ) ){
                $enqueue[] = $styles['media'];
            }

            $enqueue = implode( ', ', $enqueue );

            wp_enqueue_style( $enqueue );

        }

    }

    public function exists()
    {
        return ( file_exists( $this->path ) );
    }

    public function getContents()
    {

    }

    public function with( ...$data ){
        $this->data = $data;

        return $this;
    }

}
