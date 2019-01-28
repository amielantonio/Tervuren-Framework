<?php

namespace App\Database\SQL\Helpers;

use App\Database\SQL\Helpers\Grammar;
use Closure;

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
    public $columns = [];

    /**
     * Command to be used for the query
     *
     * @var string
     */
    public $command;

    /**
     * Table name of the query
     *
     * @var string
     */
    public $table;

    /**
     * Where Clause of the query
     *
     * @var array
     */
    public $where = [];

    /**
     * Identifier for distinct
     *
     * @var bool
     */
    public $distinct = false;

    /**
     * Values inside the query
     *
     * @var array
     */
    public $values = [];

    /**
     * Conditional aggregates of the query
     *
     * @var array
     */
    public $aggregates = [];

    /**
     * The groupings for the query.
     *
     * @var array
     */
    public $groups;

    /**
     * The having constraints for the query.
     *
     * @var array
     */
    public $havings;

    /**
     * The orderings for the query.
     *
     * @var array
     */
    public $orders;

    /**
     * The maximum number of records to return.
     *
     * @var int
     */
    public $limit;

    /**
     * The number of records to skip.
     *
     * @var int
     */
    public $offset;

    /**
     * The query union statements.
     *
     * @var array
     */
    public $unions;

    /**
     * @var \App\Database\SQL\Helpers\Grammar
     */
    protected $grammar;

    /**
     * All of the available clause operators.
     *
     * @var array
     */
    public $operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=', '<=>',
        'like', 'like binary', 'not like', 'ilike',
        '&', '|', '^', '<<', '>>',
        'rlike', 'regexp', 'not regexp',
        '~', '~*', '!~', '!~*', 'similar to',
        'not similar to', 'not ilike', '~~*', '!~~*',
    ];


    public function __construct()
    {
        $this->grammar = new Grammar;

    }


    /**
     * Create a select statement
     *
     * @param $columns
     * @return $this
     */
    public function select( $columns )
    {
        $this->columns = ( is_array($columns) ) ? $columns : func_get_args();
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

    public function table( $table )
    {
        $this->table = $table;
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
    public function update( $table, array $values )
    {
        $this->command = 'update';

        foreach ($values as $key => $value) {
            ksort($value);

            $this->values[$key] = $value;
        }

        $this->table = $table;

        return $this;
    }


    public function delete( $table, $id = null )
    {
        $this->command = 'delete';

        $this->table = $table;

        if( !$id == null ){
            $this->where = "";
        }

        return $this;
    }

    /**
     * Add a where clause to the statement
     *
     * @param string|array  $column
     * @param null $operator
     * @param null $value
     * @param string $link
     * @return $this
     */
    public function where( $column, $operator = null, $value = null, $link = "and" )
    {

        //Assuming the user has given an array of columns and operators,
        //resolve the clause received then add it to the where clause
        if( is_array( $column ) ){
            return $this->resolveArrayOfWhere( $column, $link );
        }

        if( $column instanceof Closure){

        }

        if( is_string( $column ) && is_null($operator && is_null($value))){
            echo $column;
        }


        var_dump($this->where[ "{$column} {$operator} {$value}" ]);

        return $this;
    }

    public function orWhere( $column, $operator = null, $value = null, $link = "or" )
    {
//        $this->where .= $this->solveWhere( $where );


        var_dump($this->where);

        return $this;
    }

    protected function resolveArrayOfWhere( $column, $link, $method = "where" )
    {
        return $this->nestedWhere( function( $query ) use ($column, $link, $method){
            foreach( $column as $key => $value ){
                 echo "query = {$query} | key: {$key} | value: {$value} <br />";

//                $this->$method( $key, '=', $value );
            }
        }, $link );
    }

    protected function nestedWhere( Closure $callback, $link )
    {
        call_user_func( $callback, $query = "Query" );

        return $this->compileWhere( $query, $link );

    }

    protected function compileWhere( $query, $link)
    {
        $this->where[] = $query;

        return $this;
    }

    public function addBindings( Array $array, $value )
    {
        $this->$array = $value;
    }


    public function whereRaw( $string )
    {

    }

    public function like( $key, $value )
    {
        $this->aggregates[] = "{$key} LIKE {$value}";

        return $this;
    }


    public function in( array $values )
    {
        $list = implode( ', ', $values );

        $this->aggregates[] = "IN ($list)";

        return $this;
    }


    public function between( $firstValue, $secondValue )
    {
        $this->aggregates[] = "BETWEEN {$firstValue} AND {$secondValue}";

        return $this;
    }


    public function having( $condition )
    {
        $this->aggregates[] = "HAVING {$condition}";

        return $this;
    }

    public function groupBy( $column )
    {
        $this->aggregates[] = "GROUP BY {$column}";

        return $this;
    }

    public function orderBy( $column, $option = "ASC" )
    {
        $defaults = ['ASC', 'DESC']; $columns = "";

        //Check on the option that was passed by the user
        if( ! in_array( $option, $defaults ) ){
            $option = "ASC"; //Go back to default;
        }

        //Check if column is an array
        if( is_array($column) ){
            $columns = implode( ', ', $column );
        }

        //Check if column is a string
        if( is_string($column)){
            $columns = $column;
        }

        $this->aggregates[] = "ORDER BY {$columns} {$option}";

        return $this;
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

        if( is_array( $where )){
            //Resolve the where clause when an array is being passed


        }


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


    public function getCommand()
    {
        return $this->command;
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
     *
     * @return string
     */
//    public function __toString()
//    {
//
//        $this->statement = $statement = $this->buildStatement();
//
//        return $statement;
//    }

    /**
     * Return a string representation of the query
     *
     * @return string
     */
    public function toString()
    {
        $this->statement = $statement = $this->buildStatement();

        return $statement;
    }
}
