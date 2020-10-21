<?php

namespace AWC\Helpers;

class Arr {

    /**
     * Raw array
     *
     * @var array
     */
    protected $array = [];

    /**
     * Response on modified array
     *
     * @var
     */
    protected $result;


    public function __construct( Array $array = [] )
    {
        $this->array = $array;
    }

    public function all()
    {
        return $this->result;
    }


    /**
     * Flatten array into a one dimensional array
     *
     * @param $array
     * @return array
     */
    public function flatten( $array )
    {
        $result = [];

        if( ! is_array( $array )) {
            $array = func_get_args();
        }
        foreach( $array as $key => $value ){
            if( is_array($value) ){
                $result = array_merge( $result, $this->flatten($value));
            }else{
                $result = array_merge( $result, [ $key => $value ]);
            }
        }
        return $result;

    }

    /**
     * Return a map for each of the items
     *
     * @param callable $callback
     * @return Arr
     */
    public function map( callable $callback )
    {
        $keys = array_keys($this->array);

        $items = array_map( $callback, $this->array, $keys );

        $this->result = array_combine($keys, $items);

        return $this;
    }

    public function wrap($value)
    {
        if( is_null($value)){
            return [];
        }

        return !is_array($value) ? [''] : $value;
    }

    /**
     * Return the resulting array
     *
     * @return mixed
     */
    public function get()
    {
        return $this->result;
    }


    public function implode( $glue )
    {
        return implode( $glue, $this->result );
    }

}
