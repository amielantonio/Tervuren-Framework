<?php

namespace App\Database\SQL\Helpers;

use App\Database\SQL\Helpers\Grammar;
use Closure;
use Exception;

class Query {

    /**
     * Query statement
     *
     * @var string
     */
    protected $statement;

    /**
     * Columns to be accessed by the query
     *
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

    /**
     * The current query value bindings.
     *
     * @var array
     */
    public $bindings = [
        'select' => [],
        'from'   => [],
        'join'   => [],
        'where'  => [],
        'having' => [],
        'order'  => [],
        'union'  => [],
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
     * @throws exception
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
     * Add a Where Clause to the query
     *
     * @param $column
     * @param null $operator
     * @param null $value
     * @param string $link
     * @return $this|Query
     * @throws Exception
     */
    public function where( $column, $operator = null, $value = null, $link = "and" )
    {

        //Assuming the user has given an array of columns and operators,
        //resolve the clause received then add it to the where clause
        if( is_array( $column ) ){
            return $this->resolveArrayOfWhere( $column, $link );
        }

        // Here we will make some assumptions about the operator. If only 2 values are
        // passed to the method, we will assume that the operator is an equals sign
        // and keep going. Otherwise, we'll require the operator to be passed in.
        list($value, $operator) = $this->prepareValueAndOperator(
            $value, $operator, func_num_args() === 2
        );

        // If the columns is actually a Closure instance, we will assume the developer
        // wants to begin a nested where statement which is wrapped in parenthesis.
        // We'll add that Closure to the query then return back out immediately.
        if( $column instanceof Closure ){
            return $this->nestedWhere($column, $link);
        }

        // If the given operator is not found in the list of valid operators we will
        // assume that the developer is just short-cutting the '=' operators and
        // we will set the operators to '=' and set the values appropriately.
        if ($this->invalidOperator( $operator )) {
            list($value, $operator) = [$operator, '='];
        }

        // If the value is "null", we will just assume the developer wants to add a
        // where null clause to the query. So, we will allow a short-cut here to
        // that method for convenience so the developer doesn't have to check.
        if (is_null($value)) {
            return $this->whereNull($column, $link, $operator !== '=');
        }

        $this->where[] = compact( 'column', 'operator', 'value', 'link');


        $this->addBinding($this->where);

        return $this;
    }

    public function orWhere( $column, $operator = null, $value = null, $link = "or" )
    {
//        $this->where .= $this->solveWhere( $where );


//        var_dump($this->where);

        return $this;
    }

    public function whereNull($column, $boolean = 'and', $not = false)
    {
        return $this;
    }

    protected function resolveArrayOfWhere( $column, $link )
    {
        return $this->nestedWhere( function() use ( $column, $link ){
            foreach( $column as $key => $value ){
                 if( is_numeric( $key ) ){
                     $this->addBinding('where', ...array_values($value));
                 }else {
                     $this->addBinding('where', "test");
                 }
            }
        }, $link );
    }

    protected function nestedWhere( Closure $callback, $link )
    {
        call_user_func( $callback );

        return $this->compileWhere( $link );
    }

    public function compileWhere( $link )
    {
//        if( count($this->where) ){
//            foreach( $this->bindings['where'] as $sentence ){
//
//            }
//        }

//        var_dump($this->bindings['where']);

        return $this;
    }

    protected function invalidOperatorAndValue($operator, $value)
    {
        return is_null($value) && in_array($operator, $this->operators) &&
            ! in_array($operator, ['=', '<>', '!=']);
    }

    /**
     * @param $value
     * @param $operator
     * @param bool $useDefault
     * @return array
     * @throws Exception
     */
    public function prepareValueAndOperator( $value, $operator, $useDefault = false )
    {
        if ($useDefault) {
            return [$operator, '='];
        } elseif ($this->invalidOperatorAndValue( $operator, $value )) {
            throw new exception('Illegal operator and value combination.');
        }

        return [$value, $operator];
    }

    public function checkOperatorAndValue( $operator, $value )
    {
        // if the operator is null, assumes that the developer is sending only 2
        if( ! is_null( $operator ) && is_null( $value )){

        }
    }

    public function resolveWhere( $where )
    {

    }

    /**
     * Add binding to the query
     *
     * @param $value
     * @param string $type
     * @param string $link
     * @return $this
     * @throws Exception
     */
    public function addBinding( $value, $type = 'where', $link = 'and' )
    {
        if( ! array_key_exists($type, $this->bindings)){
            throw new exception("No Bindings of this sort!");
        }

//        if (is_array($value)) {
//            $this->bindings[$type] = $value;
//        } else {
//            $this->bindings[$type][] = [
//                "query" => $value,
//                "link" => $link
//            ];
//        }


        var_dump( $value ) ;

        if (is_array($value)) {
            $this->bindings[$type] = array_values(array_merge($this->bindings[$type], $value));
        } else {
            $this->bindings[$type][] = $value;
        }

        return $this;
    }

    public function getBindings()
    {
        return $this->bindings;
    }


    public function whereRaw( $string )
    {

    }

    /**
     * Determine if the operator is supported
     *
     * @param $operator
     * @return bool
     */
    protected function invalidOperator( $operator )
    {
        return ! in_array(strtolower($operator), $this->operators, true );
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
