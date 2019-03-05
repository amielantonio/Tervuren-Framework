<?php

namespace App\Database\SQL\Helpers;

use App\Database\SQL\Helpers\Query;
use App\Helpers\Arr;

class Grammar
{

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
    public function compileSelect(Query $query)
    {
        if (is_null($query->columns)) {
            $query->columns = ['*'];
        }

        $sql = trim($this->concatenate(
            $this->compileComponents($query))
        );

        return $sql;
    }

    /**
     * compile components
     *
     * @param \App\Database\SQL\Helpers\Query $query
     * @return array
     */
    protected function compileComponents(Query $query)
    {
        $sql = [];

        foreach ($this->selectComponents as $component) {
            if (!is_null($query->$component)) {
                $method = 'compile' . ucfirst($component);
                if( $component == 'joins'){
//                    var_dump($query->joins);
                }

                $sql[$component] = $this->$method($query, $query->$component);
            }
        }

        return $sql;
    }

    protected function compileAggregate(Query $query, $aggregate)
    {
        $column = $this->columnize($aggregate['columns']);

        // If the query has a "distinct" constraint and we're not asking for all columns
        // we need to prepend "distinct" onto the column name so that the query takes
        // it into account when it performs the aggregating operations on the data.
        if ($query->distinct && $column !== '*') {
            $column = 'DISTINCT ' . $column;
        }

        return 'SELECT ' . $aggregate['function'] . '(' . $column . ') AS aggregate';
    }

    protected function compileFrom(Query $query, $table)
    {
        return "FROM {$table}";
    }

    /**
     * compileJoins
     *
     * @param \App\Database\SQL\Helpers\Query $query
     * @param $joins
     * @return string
     */
    protected function compileJoins(Query $query, $joins)
    {

        return (new Arr($joins))->map(function ($join) use ($query) {
            $table = $join->table;

            $nestedJoins = is_null($join->joins) ? '' : ' ' . $this->compileJoins($query, $join->joins);

            return trim("{$join->type} JOIN {$table}{$nestedJoins} {$this->compileWhere( $join )}");
        })->implode(" ");

    }

    /**
     *
     *
     * @param \App\Database\SQL\Helpers\Query $query
     * @return string
     */
    public function compileWhere(Query $query)
    {
        // Each type of where clauses has its own compiler function which is responsible
        // for actually creating the where clauses SQL. This helps keep the code nice
        // and maintainable since each clause has a very small method that it uses.
        if (is_null($query->where)) {
            return '';
        }


        // If we actually have some where clauses, we will strip off the first boolean
        // operator, which is added by the query builders for convenience so we can
        // avoid checking for the first clauses in each of the compilers methods.
        if (count( $sql = $this->compileWheresToArray($query) ) > 0) {
            return $this->concatenateWhereClauses($query, $sql);
        }

        return '';
    }


    /**
     * Format the where clause statements into one string.
     *
     * @param $query
     * @param $sql
     * @return string
     */
    protected function concatenateWhereClauses( $query, $sql )
    {
        $conjunction = $query instanceof JoinClause ? "ON" : 'WHERE';

        return $conjunction . ' ' . $this->removeLeadingBoolean(implode(' ', $sql));
    }

    /**
     * Parse Array and return statement
     *
     * @param $query
     * @return array
     */
    protected function compileWheresToArray( $query )
    {



        return ( new Arr($query->where) )->map( function( $where ) use ($query){

            var_dump($where);

//            return $where['link'].' '.$this->{"where{$where['type']}"}($query, $where);
        })->all();
    }

    /**
     * Create a raw Where clause
     *
     * @param \App\Database\SQL\Helpers\Query $query
     * @param $where
     * @return mixed
     */
    protected function whereRaw(Query $query, $where)
    {
        return $where['sql'];
    }

    /**
     * Return a Basic where statement
     *
     * @param \App\Database\SQL\Helpers\Query $query
     * @param $where
     * @return string
     */
    protected function whereBasic(Query $query, $where)
    {
        return $where['column'] . " " . $where['operator'] . " '" . $where['value'] . "'";
    }

    /**
     * @param \App\Database\SQL\Helpers\Query $query
     * @param $where
     * @return string
     */
    protected function whereIn(Query $query, $where)
    {
        return $where['column'] . " IN ({$this->columnize($where['values'])})";
    }

    /**
     * @param \App\Database\SQL\Helpers\Query $query
     * @param $where
     * @return string
     */
    protected function whereNotIn(Query $query, $where)
    {
        return $where['column'] . " NOT IN ({$this->columnize($where['values'])})";
    }

    /**
     * @param \App\Database\SQL\Helpers\Query $query
     * @param $where
     * @return string
     */
    protected function whereNull(Query $query, $where)
    {
        return "{$where['column']} IS NULL";
    }

    /**
     * @param \App\Database\SQL\Helpers\Query $query
     * @param $where
     * @return string
     */
    protected function whereNotNull(Query $query, $where)
    {
        return "{$where['column']} IS NOT NULL";
    }

    /**
     * @param \App\Database\SQL\Helpers\Query $query
     * @param $where
     * @return string
     */
    protected function whereBetween(Query $query, $where)
    {
        return $where['column'] . " BETWEEN '" . $where['values'][0] . "' AND '" . $where['values'][1] . "'";
    }

    /**
     * @param \App\Database\SQL\Helpers\Query $query
     * @param $where
     * @return string
     */
    protected function whereColumn(Query $query, $where)
    {
        return $where['first']. ' '.$where['operator'].' '.$where['second'];
    }


    protected function compileGroups(Query $query, $groups)
    {
        return '';
    }

    protected function compileHavings(Query $query, $havings)
    {
        return '';
    }

    protected function compileOrders(Query $query, $orders)
    {
        return '';
    }

    protected function compileLimit(Query $query, $limit)
    {
        return '';
    }

    protected function compileOffset(Query $query, $offset)
    {
        return '';
    }

    protected function compileUnions(Query $query, $unions)
    {
        return '';
    }

    protected function compileLock(Query $query, $lock)
    {
        return '';
    }

    public function compileInsert(Query $query, array $values)
    {
        $table = $query->table;

        $columns = $this->columnize(array_keys(reset($values)));

        $parameters = $this->parameterize(array_values(reset($values)));

        return "INSERT INTO {$table}({$columns}) VALUES {$parameters}";
    }

    /**
     * Create query parameter place-holders for an array.
     *
     * @param  array $values
     * @return string
     */
    public function parameterize(array $values)
    {
        return implode(', ', $values);
    }


    /**
     * @param \App\Database\SQL\Helpers\Query $query
     *
     * @return string
     */
    public function compileDelete(Query $query)
    {

        return "";
    }

    /**
     *
     *
     * @param \App\Database\SQL\Helpers\Query $query
     * @param array $values
     * @return string
     */
    public function compileUpdate(Query $query, array $values)
    {
        $table = $query->table;

        $columns = (new Arr($values))->map(function ($value, $key) {
            return "{$key}='{$value}'";
        })->implode(', ');

        $wheres = $this->compileWhere($query);

        return trim("UPDATE {$table} SET {$columns} {$wheres}");
    }


    protected function compileColumns(Query $query, $columns)
    {
        $select = $query->distinct ? 'SELECT DISTINCT ' : 'SELECT ';

        return $select . $this->columnize($columns);
    }


    public function columnize(array $columns)
    {
        return implode(', ', $columns);
    }


    /**
     * Concatenate an array of segments, removing empties.
     *
     * @param  array $segments
     * @return string
     */
    protected function concatenate($segments)
    {
        return implode(' ', array_filter($segments, function ($value) {
            return (string)$value !== '';
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
