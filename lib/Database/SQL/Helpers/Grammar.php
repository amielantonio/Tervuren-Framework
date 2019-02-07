<?php

namespace App\Database\SQL\Helpers;

use App\Database\SQL\Helpers\Query;

class Grammar {

    /**
     * The grammar specific operators.
     *
     * @var array
     */
    protected $operators = [];

    /**
     * Compile Select Statement
     *
     * @param \App\Database\SQL\Helpers\Query $query
     * @return string
     */


    protected $selectComponents = [
        'aggregate',
        'columns',
        'from',
        'joins',
        'where',
        'groups',
        'havings',
        'orders',
        'limit',
        'offset',
        'unions',
        'lock',
    ];


    /**
     * Compile a SELECT Query into an SQL
     *
     * @param \App\Database\SQL\Helpers\Query $query
     * @return string
     */
    public function compileSelect( Query $query )
    {
        if( is_null( $query->columns ) ){
            $query->columns = ['*'];
        }

        $sql = trim($this->concatenate(
            $this->compileComponents($query))
        );

        return $sql;
    }

    /**
     *
     *
     * @param \App\Database\SQL\Helpers\Query $query
     * @return array
     */
    protected function compileComponents( Query $query )
    {
        $sql = [];

        foreach( $this->selectComponents as $component ){
            if( ! is_null( $query->$component)){
                $method = 'compile'.ucfirst($component);

                $sql[$component] = $this->$method($query, $query->$component);
            }
        }

        return $sql;
    }

    protected function compileAggregate( Query $query, $aggregate )
    {
        $column = $this->columnize($aggregate['columns']);

        // If the query has a "distinct" constraint and we're not asking for all columns
        // we need to prepend "distinct" onto the column name so that the query takes
        // it into account when it performs the aggregating operations on the data.
        if ($query->distinct && $column !== '*') {
            $column = 'DISTINCT '.$column;
        }

        return 'SELECT '.$aggregate['function'].'('.$column.') AS aggregate';
    }

    protected function compileFrom( Query $query, $table )
    {

        echo "from";
        return "FROM {$table}";
    }

    protected function compileJoins( Query $query, $joins )
    {

    }

    protected function compileWhere( Query $query, $wheres )
    {
        if (is_null($wheres)){
            return '';
        }


        if( count($sql = $this->wheretoArray( $query ) ) > 0 ){
//            var_dump($query->where);
            return $this->concatenateWhereClauses( $query, $sql );
        }

        return '';
    }


    //final
    protected function concatenateWhereClauses($query, $sql)
    {
        $conjunction =  'WHERE';

        return $conjunction.' '.$this->removeLeadingBoolean(implode(' ', $sql));
    }

    protected function wheretoArray( $query )
    {
        $wheres = [];

        foreach( $query->where as $key => $where ){
            $wheres[] = "{$where['link']} {$where['column']} {$where['operator']} {$where['value']}";
        }

        return $wheres;

    }

    protected function compileGroups( Query $query, $groups )
    {

    }

    protected function compileHavings( Query $query, $havings )
    {

    }

    protected function compileOrders( Query $query, $orders )
    {

    }

    protected function compileLimit( Query $query, $limit )
    {

    }

    protected function compileOffset( Query $query, $offset )
    {

    }

    protected function compileUnions( Query $query, $unions )
    {

    }

    protected function compileLock( Query $query, $lock )
    {

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

    public function compileUpdate( Query $query, array $values )
    {

        $table = $query->table;
    }


    protected function compileColumns( Query $query, $columns )
    {
        $select = $query->distinct ? 'SELECT DISTINCT ' : 'SELECT ' ;

        return $select.$this->columnize($columns);
    }


    public function columnize( array $columns )
    {
        return implode(', ', $columns );
    }


    /**
     * Concatenate an array of segments, removing empties.
     *
     * @param  array   $segments
     * @return string
     */
    protected function concatenate($segments)
    {
        return implode(' ', array_filter($segments, function ($value) {
            return (string) $value !== '';
        }));
    }

    protected function removeLeadingBoolean($value)
    {
        return preg_replace('/and |or /i', '', $value, 1);
    }

    public function getOperators()
    {
        return $this->operators;
    }


}
