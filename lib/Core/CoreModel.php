<?php
namespace App\Core;

use App\Database\SQL\Helpers\Query;

abstract class CoreModel {


    /**
     * The table that is being specified
     *
     * @var string
     */
    protected $table;

    /**
     * Primary key of the table
     *
     * @var string
     */
    protected $primary_key;


    /**
     * Column of the database
     *
     * @var array
     */
    protected  $columns = [];


    /**
     * Resulting Data
     *
     * @var array|object|string
     */
    protected $result;

    /**
     * @var \wpdb
     */
    private $wpdb;

    /**
     * Query class
     *
     * @var Query
     */
    protected $query;

    protected $statement;


    /**
     * DataWrapper constructor.
     */
    public function __construct()
    {
        global $wpdb;

        $this->wpdb = $wpdb;

        $this->query = new Query();

        $this->table = $wpdb->prefix . $this->table;
    }

    public function get()
    {
//        $this->result = $this->wpdb->get_results( $this->statement );
        $this->statement = $this->query->toSQL();


        return $this->statement;
    }

    /**
     * Create a select query;
     *
     * @param $columns
     * @param bool $distinct
     * @return $this
     * @throws \Exception
     */
    public function select( $columns, $distinct = false )
    {
//        $this->columns = $columns = ( is_array($columns) ) ? implode( ', ', $columns ) : $columns ;

        $this->query->select( $columns )->from( $this->table );

        if( $distinct ){
            $this->query->distinct();
        }

        return $this;
    }

    /**
     * Get all resources from the database
     *
     * @return array|null|object
     * @throws \Exception
     */
    public function getAll()
    {
        $query  = $this->query->select( '*' )->from( $this->table );

        return $this->wpdb->get_results( $query );
    }

    /**
     * Create a simple Where Clause
     *
     * @param $column
     * @param null $operator
     * @param null $value
     * @param string $link
     * @return $this
     * @throws \Exception
     */
    public function where( $column, $operator = null, $value = null, $link = "and" )
    {
        $this->query->where( $column, $operator, $value, $link );

        return $this;
    }

    /**
     * Add an "or WHERE" Closure to the query
     *
     * @param $column
     * @param null $operator
     * @param null $value
     * @return $this
     * @throws \Exception
     */
    public function orWhere( $column, $operator = null, $value = null)
    {
        $this->query->orWhere( $column, $operator, $value );

        return $this;
    }

    /**
     * add a where null statement
     *
     * @param $column
     * @return $this
     */
    public function whereNull( $column )
    {
        $this->query->whereNull( $column );

        return $this;
    }

    /**
     * add a where null statement
     *
     * @param $column
     */
    public function orWhereNull( $column )
    {
        $this->query->orWhereNull( $column );
    }

    /**
     * Add a where not null statement
     *
     * @param $column
     * @return $this
     */
    public function whereNotNull( $column )
    {
        $this->query->whereNotNull( $column );

        return $this;
    }

    /**
     * Add an where not null statement with an "or" link
     *
     * @param $column
     * @return $this
     */
    public function orWhereNotNull( $column )
    {
        $this->query->orWhereNotNull( $column );

        return $this;
    }

    /**
     * Add a where between sql statement
     *
     * @param $column
     * @param array $values
     * @return $this
     * @throws \Exception
     */
    public function whereBetween( $column, array $values )
    {
        $this->query->whereBetween( $column, $values );

        return $this;
    }

    /**
     * Add an or Where between statement with an "or" link
     *
     * @param $column
     * @param array $values
     * @return $this
     * @throws \Exception
     */
    public function orWhereBetween( $column, array $values )
    {
        $this->query->orWhereBetween( $column, $values );

        return $this;
    }

    /**
     * Add a where not between statement
     *
     * @param $column
     * @param array $values
     * @return $this
     * @throws \Exception
     */
    public function whereNotBetween( $column, array $values )
    {
        $this->query->whereNotBetween( $column, $values );

        return $this;
    }

    /**
     * Add where not between statement with an "or" link
     *
     * @param $column
     * @param array $values
     * @return $this
     * @throws \Exception
     */
    public function orWhereNotBetween( $column, array $values )
    {
        $this->query->orWhereNotBetween( $column, $values );

        return $this;
    }

    /**
     * Add a raw Where statement
     *
     * @param $sql
     * @return $this
     * @throws \Exception
     */
    public function whereRaw( $sql )
    {
        $this->query->whereRaw( $sql );

        return $this;
    }

    /**
     * Add a raw Where statement with an "or" link
     *
     * @param $sql
     * @return $this
     * @throws \Exception
     */
    public function orWhereRaw( $sql )
    {
        $this->query->orWhereRaw( $sql );

        return $this;
    }

    /**
     * @param $column
     * @param array $values
     * @return $this
     * @throws \Exception
     */
    public function whereIn( $column, array $values )
    {
        $this->query->whereIn( $column, $values );

        return $this;
    }

    /**
     * @param $column
     * @param array $values
     * @return $this
     * @throws \Exception
     */
    public function orWhereIn( $column, array $values )
    {
        $this->query->orWhereIn( $column, $values );

        return $this;
    }

    public function save()
    {

    }

    public function insertOrReplace()
    {

    }

    public function delete()
    {

    }

    public function update()
    {

    }

    /**
     * Dynamically gets an attribute to the field
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->columns[ $name ];
    }

    /**
     * Dynamically sets an attribute to the field
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->columns[ $name ] = $value;
    }

    private function compiler()
    {

    }

}
