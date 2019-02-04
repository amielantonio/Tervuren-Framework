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
        $this->statement = $this->query->toString();

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
        $this->columns = $columns = ( is_array($columns) ) ? implode( ', ', $columns ) : $columns ;

        if( $distinct ) {
            $this->query
                ->select( $columns )
                ->distinct()
                ->from( $this->table );
        }else{
            $this->query
                ->select( $columns )
                ->from( $this->table );
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

    public function where( $column, $operator = null, $value = null, $link = "and" )
    {
        $this->query->where( $column, $operator, $value, $link );

        return $this;
    }

    public function orWhere( $column, $operator = null, $value = null, $link = "and" )
    {
        $this->query->orWhere( $column, $operator, $value, $link );

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
