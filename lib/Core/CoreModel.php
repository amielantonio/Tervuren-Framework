<?php
namespace AWC\Core;

use AWC\Helpers\Arr;
use AWC\Database\SQL\Helpers\Query;

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

    /**
     * Current Resource Selected
     *
     * @var CoreModel
     */
    protected static $resource;


    /**
     * Current SQL statement being run
     *
     * @var
     */
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

    /**
     * Returns the result from a select statement running thru the WPDB command
     *
     * @return array|null|object
     */
    public function results()
    {
         $this->statement = $this->query->toSQL();

        return $this->result = $this->wpdb->get_results( $this->statement );

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
        $this->query->select( $columns )->from( $this->table );

        if( $distinct ){
            $this->query->distinct();
        }

        return $this;
    }

    /**
     * Get a certain resource from the database
     *
     * @param mixed ...$columns
     * @return array|null|object
     * @throws \Exception
     */
    public function get( ...$columns )
    {
        $columns = func_get_args();

        $query = $this->query->select( $columns )->from( $this->table );

        var_dump($query);

        return $this->wpdb->get_results( $query );
    }

    /**
     * @param $resource
     * @throws \Exception
     */
    public function find( $resource )
    {
        self::$resource = $resource;

        $columns = $this->select('*')->where( $this->primary_key, '=', $resource )->results();

        $this->columns = $columns[0];
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

    /**
     * Create a JOIN clause
     *
     * @param $table
     * @param $first
     * @param null $operator
     * @param null $second
     * @param string $type
     * @return $this
     * @throws \Exception
     */
    public function join( $table, $first, $operator = null, $second = null, $type = "inner" )
    {
        $this->query->join( $table, $first, $operator, $second, $type );

        return $this;
    }

    /**
     * Create a group by clause
     *
     * @param mixed ...$groups
     * @return $this
     */
    public function groupBy( ...$groups )
    {
        $this->query->groupBy( $groups );

        return $this;
    }

    /**
     * Create a having clause
     *
     * @param $column
     * @param $operator
     * @param $value
     * @return $this
     * @throws \Exception
     */
    public function having( $column, $operator, $value )
    {
        $this->query->having( $column, $operator, $value );

        return $this;
    }

    /**
     * Create a or Having clause for select statement
     *
     * @param $column
     * @param $operator
     * @param $value
     * @return $this
     * @throws \Exception
     */
    public function orHaving( $column, $operator, $value )
    {
        $this->query->orHaving( $column, $operator, $value );

        return $this;
    }

    /**
     * Create a raw SQL for having
     *
     * @param $sql
     * @param array $bindings
     * @return $this
     * @throws \Exception
     */
    public function havingRaw( $sql, $bindings = [] )
    {
        $this->query->havingRaw( $sql, $bindings );

        return $this;
    }

    /**
     * Create a raw having
     *
     * @param $sql
     * @param array $bindings
     * @throws \Exception
     * @return $this
     */
    public function orHavingRaw( $sql, $bindings = [] )
    {
        $this->query->orHavingRaw( $sql, $bindings );

        return $this;
    }

    /**
     * Create an order by clause in a select statement
     *
     * @param $column
     * @param string $direction
     * @return $this
     */
    public function orderBy( $column, $direction = 'asc' )
    {
        $this->query->orderBy( $column, $direction );

        return $this;
    }

    /**
     * create a descending order by statement
     *
     * @param $column
     * @return $this
     */
    public function orderByDesc( $column )
    {
        $this->query->orderBy( $column, 'desc' );

        return $this;
    }

    /**
     * raw SQL for order by clause in a select statement
     *
     * @param $sql
     * @param array $bindings
     * @return $this
     * @throws \Exception
     */
    public function orderByRaw( $sql, $bindings=[] )
    {
        $this->query->orderByRaw( $sql, $bindings );

        return $this;
    }

    public function offset( $value )
    {
        $this->query->offset( $value );

        return $this;
    }

    /**
     * return first element
     * @param array $columns
     * @return mixed
     * @throws \Exception
     */
    public function first( $columns = ['*'])
    {
        return $this->get($columns)->limit(1);
    }

    /**
     * Save existing
     *
     * @param $where
     * @return false|int
     * @throws \Exception
     */
    public function save( $where = [] )
    {
        // If the model doesn't have any records and the user is not finding any resources
        // then the user most likely needs to insert the resources given to the database.
        if( empty( $this->get( $this->columns[$this->primary_key] )->results())
            && empty( $where )) {

            return $this->wpdb->insert( $this->table, $this->columns );
        }

        // If there is a resource that was specified by the user, it means that, the user
        // is trying to do an update on that resource.
        if( ! is_null(self::$resource) ){
            return $this->wpdb->update(
                $this->table,
                $this->columns,
                [$this->primary_key => self::$resource]);
        }

        $wherePrimaryKey = [
            $this->primary_key => $this->columns[$this->primary_key]
        ];

        // Checking whether the user specified an additional where clause  for updating.
        // Merge the primary key where clause and the where clause that was specified by
        // the user. If there are no additional where clause specified, proceed using the
        // primary key where clause
        if( isset( $this->columns[ $this->primary_key ]) && ! empty( $where ) ) {
            $where = array_merge( $where, $wherePrimaryKey );
        }

        return $this->wpdb->update( $this->table, $this->columns, $where  );
    }

    /**
     * Do an update query
     *
     * @param array $columns
     * @return false|int
     */
    public function update( Array $columns )
    {
        return $this->wpdb->query( $this->query->table($this->table)->update( $columns ) );
    }

    /**
     * Deletes a resource
     *
     * @param $resource
     * @return false|int
     */
    public function delete( $resource )
    {
        return $this->wpdb->delete( $this->table, [ $this->primary_key => $resource ] );
    }

    // SOFT DELETE BOILER PLATE
    public function softDeletes( $resource )
    {

    }

    public function withTrashed()
    {

    }

    public function onlyTrashed()
    {

    }

    public function deleteTrashed()
    {

    }
    //END

    /**
     * Dynamically gets an attribute to the field
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->columns->$name;
    }

    /**
     * Dynamically sets an attribute to the field
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if( is_array( $this->columns )){
            $this->columns[$name] = $value;
        } else{
            $this->columns->$name = $value;
        }

    }



    /**
     * Call a dynamically created property
     *
     * @param $property
     * @return mixed
     */
    protected function callProperty( $property )
    {
        return $this->$property;
    }

    /**
     * Create an associative array based on the passed key and value
     *
     * @param $key
     * @param $value
     * @return array
     */
    protected function toAssocArray( $key, $value )
    {
        return [$key => $value ];
    }

}
