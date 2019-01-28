<?php

namespace App\Database\SQL\Helpers;

use App\Database\SQL\Helpers\Query;

class Grammar {

    /**
     * Compile Select Statement
     *
     * @param \App\Database\SQL\Helpers\Query $query
     * @return string
     */
    public function compileSelect( Query $query )
    {
        $command = strtoupper( $query->command );

        $distinct = ( $query->distinct ) ? "DISTINCT" : "";

        $grammar = "{$command} {$distinct} {$this->compileColumns($query->columns)} FROM {$query->table}";

        //Check for where clause
        $grammar .= (! empty( $query->where )) ? " where {$query->where}" : "";


        return $grammar;
    }

    /**
     * @param \App\Database\SQL\Helpers\Query $query
     * @return string
     */
    public function compileInsert( Query $query )
    {
        $grammar = "INSERT INTO {$query->table}";

        return "";
    }

    /**
     * @param \App\Database\SQL\Helpers\Query $query
     * @return string
     */
    public function compileDelete( Query $query )
    {

        return "";
    }

    public function compileUpdate( Query $query )
    {

        return "";
    }


    protected function compileColumns( $columns )
    {
        if( is_array( $columns ) ){
            //Check whether the columns that was passed is an array,
            //parsed then return the processed columns
            return implode( ', ', $columns );
        }

        if( is_string( $columns ) ){
            //Check if the columns is already formatted as a string
            return $columns;
        }

        return $columns;

    }

}
