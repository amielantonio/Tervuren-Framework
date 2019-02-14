<?php

namespace App\Database\SQL\Helpers;

use App\Database\SQL\Helpers\Grammar;
use App\Database\SQL\Helpers\Expression;
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
        $this->table = $this->from = $table;

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
    public function update( array $values )
    {
//        $sql = $this->grammar->compileUpdate( $this, $values );


    }


    public function delete( $table, $id = null )
    {

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
            return $this->nestedWhere($column);
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

        $type = "Basic";

        $this->where[] = compact( 'type', 'column', 'operator', 'value', 'link' );

        $this->addBinding($this->where);

        return $this;
    }

    /**
     *
     * @param $column
     * @param null $operator
     * @param null $value
     * @return Query
     * @throws Exception
     */
    public function orWhere( $column, $operator = null, $value = null )
    {
        list($value, $operator) = $this->prepareValueAndOperator(
            $value, $operator, func_num_args() === 2
        );

        return $this->where($column, $operator, $value, 'or');
    }

    /**
     * @param $column
     * @param string $link
     * @param bool $not
     * @return $this
     */
    public function whereNull($column, $link = 'and', $not = false)
    {
        $type = $not ? 'NotNull' : 'Null';

        $this->where[] = compact( 'type', 'column', 'link' );

        return $this;
    }

    public function orWhereNull( $column )
    {
        return $this->whereNull( $column, 'or' );
    }

    /**
     * Add a "where not null" clause to the query.
     *
     * @param $column
     * @param string $link
     * @return Query
     */
    public function whereNotNull( $column, $link = "and ")
    {
        return $this->whereNull( $column, $link, true );
    }

    /**
     *  Add an "or where not null" clause to the query.
     *
     * @param $column
     * @return Query
     */
    public function orWhereNotNull($column)
    {
        return $this->whereNotNull($column, 'or');
    }

    /**
     * @param $column
     * @param array $values
     * @param string $link
     * @param bool $not
     * @return $this
     * @throws Exception
     */
    public function whereBetween( $column, array $values, $link = 'and', $not = false )
    {
        $type = 'Between';

        $this->where[] = compact('type', 'column', 'values', 'link', 'not');

        $this->addBinding($this->cleanBindings($values), 'where');

        return $this;
    }

    /**
     * Add an or where between statement to the query.
     *
     * @param $column
     * @param array $values
     * @return Query
     * @throws Exception
     */
    public function orWhereBetween($column, array $values)
    {
        return $this->whereBetween($column, $values, 'or');
    }

    /**
     * Add a where not between statement to the query.
     *
     * @param $column
     * @param array $values
     * @param string $link
     * @return Query
     * @throws Exception
     */
    public function whereNotBetween($column, array $values, $link = 'and')
    {
        return $this->whereBetween($column, $values, $link, true);
    }

    /**
     * Add an or where not between statement to the query.
     *
     * @param $column
     * @param array $values
     * @return Query
     * @throws Exception
     */
    public function orWhereNotBetween($column, array $values)
    {
        return $this->whereNotBetween($column, $values, 'or');
    }

    /**
     * Add a raw where clause to the query.
     *
     * @param $sql
     * @param array $bindings
     * @param string $link
     * @return $this
     * @throws Exception
     */
    public function whereRaw($sql, $bindings = [], $link = 'and')
    {
        $this->where[] = ['type' => 'Raw', 'sql' => $sql, 'link' => $link];

        $this->addBinding((array) $bindings, 'where');

        return $this;
    }

    /**
     * Add a raw or where clause to the query.
     *
     * @param $sql
     * @param array $bindings
     * @return Query
     * @throws Exception
     */
    public function orWhereRaw( $sql, $bindings = [] )
    {
        return $this->whereRaw( $sql, $bindings, 'or' );
    }

    /**
     * @param $column
     * @param $values
     * @param string $link
     * @param bool $not
     * @return $this
     * @throws Exception
     */
    public function whereIn( $column, $values, $link = 'and', $not = false )
    {
        $type = $not ? 'NotIn' : 'In';


        $this->where[] = compact( 'type', 'column', 'values', 'link' );

        foreach ($values as $value) {
            if (! $value instanceof Expression) {
                $this->addBinding( $value, 'where');
            }
        }

        return $this;
    }

    /**
     * @param $column
     * @param $values
     * @return Query
     * @throws Exception
     */
    public function orWhereIn($column, $values)
    {
        return $this->whereIn($column, $values, 'or');
    }

    /**
     * @param $column
     * @param $link
     * @param string $method
     * @return Query
     * @throws Exception
     */
    protected function resolveArrayOfWhere( $column, $link, $method = "where" )
    {
        return $this->nestedWhere( function() use ( $column, $link, $method ){
            foreach( $column as $key => $value ){
                 if( is_numeric( $key ) ){
                     foreach( $value as $valKey => $valValue){
                         $this->$method($valKey, '=', $valValue, $link );
                     }
                 }else {

                     $this->$method($key,'=',$value, $link);
                 }
            }
        } );
    }

    /**
     * @param Closure $callback
     * @param $link
     * @return Query
     * @throws Exception
     */
    protected function nestedWhere( Closure $callback )
    {
        call_user_func( $callback );

        return $this->compileWhere();
    }

    /**
     * @param $link
     * @return $this
     * @throws Exception
     */
    public function compileWhere()
    {
       if (count($this->where)) {

            $this->addBinding($this->getRawBindings()['where'], 'where');

        }

        return $this;
    }

    public function getRawBindings()
    {
        return $this->bindings;
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

        if (is_array($value)) {
            $this->bindings[$type] = $value;
        } else {
            $this->bindings[$type][] = $value;
        }

        return $this;
    }

    /**
     * Remove all of the expressions from a list of bindings.
     *
     * @param  array  $bindings
     * @return array
     */
    protected function cleanBindings(array $bindings)
    {
        return array_values(array_filter($bindings, function ($binding) {
            return ! $binding instanceof Expression;
        }));
    }

    public function getBindings()
    {
        return $this->bindings;
    }




    /**
     * Determine if the operator is supported
     *
     * @param $operator
     * @return bool
     */
    protected function invalidOperator( $operator )
    {
        return ! in_array(strtolower($operator), $this->operators, true) &&
            ! in_array(strtolower($operator), $this->grammar->getOperators(), true);
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
     * Return a string representation of the query
     *
     * @return string
     */
    public function toSQL()
    {
        $this->statement = $statement = $this->grammar->compileSelect( $this );

        return $statement;
    }
}
