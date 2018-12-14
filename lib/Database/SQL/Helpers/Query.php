<?php

namespace App\Database\SQL\Helpers;

use App\Database\SQL\Helpers\Grammar;

class Query {

    /**
     * Query statement
     *
     * @var string
     */
    protected $statement;

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * Command to be used for the query
     *
     * @var string
     */
    protected $command;

    /**
     * Table name of the query
     *
     * @var string
     */
    protected $table;

    protected $where = [];

    protected $distinct = false;

    protected $values = [];

    protected $aggregates = [];

    /**
     * @var \App\Database\SQL\Helpers\Grammar
     */
    protected $grammar;


    public function __construct()
    {
        $this->grammar = new Grammar;

    }


    /**
     * Create a select statement
     *
     * @param $fieldsu di j
     * @return $this
     */
    public function select( $fields )
    {
        $this->columns = ( is_array($fields) ) ? $fields : func_get_args();
        $this->command = 'select';

        return $this;
    }

    /**
     * Create Distinct
     *
     * @return $this
     */
    public function distinct()
    {
        $this->distinct = true;

        return $this;
    }

    /**
     * From statement
     *
     * @param $table
     * @return $this
     */
    public function from( $table )
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Create an insert statement
     *
     * @param array $values
     * @param string $table
     * @return $this
     */
    public function insert( array $values, $table )
    {
        $this->command = 'insert';

        foreach ($values as $key => $value) {
            ksort($value);

            $this->values[$key] = $value;
        }

        $this->table = $table;


        return $this;
    }

    /**
     * @param array $values
     * @param $table
     * @return $this
     */
    public function update( array $values, $table )
    {
        $this->command = 'update';

        foreach ($values as $key => $value) {
            ksort($value);

            $this->values[$key] = $value;
        }

        $this->table = $table;

        return $this;
    }


    public function delete( $id = null )
    {

    }

    /**
     * Create where clause
     *
     * @param $where
     * @return $this
     */
    public function where( $where )
    {
        $this->where = $this->solveWhere( $where );


        return $this;
    }

    public function orWhere( $where )
    {
        $this->where .= $this->solveWhere( $where );


        return $this;
    }

    public function like( $key, $value )
    {
        $sentence = "{$key} LIKE {$value}";


        return $this;
    }

    public function in( array $values )
    {
        $this->aggregates = [
            'key' => 'in',
            'value' => $values
        ];

        return $this;
    }

    public function between( $firstValue, $secondValue )
    {

        return $this;
    }

    public function having( $condition )
    {

        return $this;
    }

    public function groupBy( $column )
    {

        return $this;
    }

    public function orderBy( $column, $option )
    {

    }

    /**
     * Get the statement
     *
     * @return string
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * Set the statement
     *
     * @param $statement
     */
    public function setStatement( $statement )
    {
        $this->statement = $statement;
    }

    protected function solveWhere( $where )
    {
        $sentence = "(";

        if( is_array( $where ) ){
            $x = 1;
            foreach( $where as $item ){
                if( is_array( $item ) ){
                    $sentence .= implode( '', $item );
                    if($x < count($where )){
                        $sentence .= " AND ";
                    }

                } else {
                    $sentence .= implode( '', $where );
                    break;
                }
                $x++;
            }
        } else {
            $sentence .= $where;
        }

        $sentence .= ")";

        return $sentence;
    }

    /**
     * Build the SQL Statement
     *
     * @return string
     */
    protected function buildStatement()
    {
        $statement = "";

        switch ($this->command){
            case 'select':
                $statement = $this->grammar->compileSelect( $this );
                break;
            case 'insert':
                $statement = $this->grammar->compileInsert( $this );
                break;
            case 'update':
                $statement = $this->grammar->compileUpdate( $this );
                break;
            case 'delete':
                $statement = $this->grammar->compileDelete( $this );
                break;
            default:

        }

        return $statement;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.

        $this->statement = $statement = $this->buildStatement();

        return $statement;
    }
}
