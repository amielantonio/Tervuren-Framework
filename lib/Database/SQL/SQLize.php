<?php

namespace App\Database\SQL;

use App\Database\SQL\Blueprint;


/**
 * Used to format the blueprints sql
 *
 * Class SQLize
 * @package App\Database\SQL
 */
class SQLize{

    /**
     * Defines the current SQL
     *
     * @var string
     */
    protected $sql = "";

    /**
     * Defines the current attributes to be formatted
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Blueprint::class instance
     *
     * @var \App\Database\SQL\Blueprint;
     */
    protected $blueprint;


    /**
     * $WPDB instance
     *
     * @var \wpdb
     */
    protected $wpdb;

    /**
     * Database Collation
     *
     * @var string;
     */
    protected $collation;


    /**
     * SQLized columns
     *
     * @var array
     */
    protected $columns = [];

    /**
     * SQLize constructor.
     * @param \App\Database\SQL\Blueprint $blueprint
     * @param $collation
     */
    public function __construct( Blueprint $blueprint, $collation )
    {

        global $wpdb;

        $this->wpdb = $wpdb;
        $this->blueprint = $blueprint;
        $this->collation = $collation;

    }

    public function format()
    {
        return $this->attributes;
    }

    public function sqlPrefix()
    {
        $starter = strtoupper( $this->extractMainCommand()['name'] );

        $this->attributes[] = $starter. " TABLE IF NOT EXISTS" . $this->blueprint->getTable();
    }

    /**
     * Formats the given array into an SQL
     *
     * @return string
     */
    public function toSQL()
    {
        return $this->sql;
    }

    public function extractCommand( $name )
    {

    }

    public function extractColumns()
    {
        foreach( $this->blueprint->getColumns() as $key => $fields ){
            $this->columns[] = $fields[ 'name' ] . $fields[ '' ] . "";
        }
    }



    public function extractMainCommand()
    {
        return array_shift( $this->blueprint->getCommands() );
    }

}
