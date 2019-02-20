<?php

namespace App\Helpers;

class Arr {

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

}
