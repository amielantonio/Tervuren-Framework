<?php

namespace App\Database\SQL\Helpers;


class Query {

    /**
     * Query statement
     *
     * @var string
     */
    protected $statement;

    /**
     * Query Schema
     *
     * @var array
     */
    protected $schema = [];

    /**
     * Table name of the query
     *
     * @var string
     */
    protected $table;


    public function select( $fields )
    {

        $this->addSchema( 'command', 'select' );
        $this->addSchema( 'fields', $fields );

        return $this;
    }

    public function distinct()
    {
        $this->addSchema( 'distinct', true );

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
        $this->addSchema( 'table', $table );

        return $this;
    }

    /**
     * Execute the
     *
     * @return array
     */
    public function execute()
    {
        $this->statement = $statement = $this->buildStatement();

//        return $statement;
        return $this->schema;
    }


    public function insert()
    {
        $this->addSchema( 'command' , 'insert' );

        return $this;
    }

    public function update()
    {
        $this->addSchema( 'command', 'update' );
        return $this;
    }


    public function delete()
    {
        $this->addSchema( 'command', 'delete' );
        return $this;
    }

    /**
     * Create where clause
     *
     * @param $where
     * @return $this
     */
    public function where( $where )
    {
        $sentence = "";

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

        $this->addSchema( 'WHERE', $sentence );

        return $this;
    }

    public function orWhere( $where )
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

    /**
     * Get the schema array
     *
     * @return array
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * Add attributes to the schema
     *
     * @param $key
     * @param $value
     */
    protected function addSchema( $key, $value )
    {
        $this->schema[$key] = $value;
    }

    protected function solveWhere( $where )
    {

    }

    /**
     * Build the SQL Statement
     *
     * @return string
     */
    protected function buildStatement()
    {
        $statement = '';

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
