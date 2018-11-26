<?php

namespace App\Database\Builder;

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
     * Select Query
     *
     * @var string
     */
    protected $_select;

    /**
     * Where Query
     *
     * @var string
     */
    protected $_where;


    /**
     * Order Query
     *
     * @var string
     */
    protected $_order;

    /**
     * Fields for the database
     *
     * @var array
     */
    protected  $fields = [];

    /**
     * DataWrapper constructor.
     */
    public function __construct()
    {

    }

    public function get()
    {

    }

    public function select()
    {

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

    protected function _statement()
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
