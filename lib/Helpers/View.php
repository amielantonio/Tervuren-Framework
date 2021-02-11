<?php

namespace AWC\Helpers;

use ReflectionMethod;

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

    /**
     * View constructor.
     *
     * @param $view
     * @param array $data
     */
    public function __construct( $view, $data = [] )
    {
        $this->view = $view;
        $this->data = $data;

        $this->path = S_VIEWPATH . "/{$this->view}.view.php";
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

    /**
     * Check if the view file exists
     *
     * @return bool
     */
    public function exists()
    {
        return ( file_exists( $this->path ) );
    }

    /**
     * Adds the Data to the view
     *
     * @param $array
     * @return array
     */
    public function addData( $array )
    {
        return $this->data =  array_merge( $this->data, $array );
    }

    /**
     * Include data on form
     *
     * @param mixed ...$data
     * @return $this
     */
    public function with( $key, $value ){

        $this->addData( [$key => $value] );

        return $this;
    }

}
