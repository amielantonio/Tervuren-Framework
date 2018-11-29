<?php

namespace App\Database\Builder;

use App\Database\Sql\Helpers\Query;

/**
 * Class DataWrapper
 *
 * A $wpdb class wrapper, for more Object Oriented approach for the MVC Pattern
 *
 * @package App\Database\Builder
 */
abstract class DataWrapper{

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
     * Fields for the database
     *
     * @var array
     */
    protected  $fields = [];


    /**
     * Resulting Data
     *
     * @var array|object|string
     */
    protected $result;


    private $wpdb;

    /**
     * DataWrapper constructor.
     */
    public function __construct()
    {
        global $wpdb;

        $this->wpdb = $wpdb;

        $this->table = $wpdb->prefix . $this->table;
    }

    public function get()
    {
        return $this->result;
    }

    /**
     * Create a select query;
     *
     * @param mixed ...$fields
     * @return $this
     */
    public function select( ...$fields )
    {
        $query = ( new Query )
            ->select( $fields )
            ->distinct()
            ->from( $this->table )
            ->where( [['console','=','1'],['console','<>','1']] )->execute();

        var_dump($query);

        return $this;
    }

    public function getAll()
    {

    }

    public function first()
    {

    }

    public function last()
    {

    }

    public function where(){

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
        return $this->fields[ $name ];
    }

    /**
     * Dynamically sets an attribute to the field
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->fields[ $name ] = $value;
    }

}
