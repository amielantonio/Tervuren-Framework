<?php

namespace App\Database\SQL;

use Closure;
use App\Database\SQL\Blueprint;
use App\Database\SQL\Helpers\Column;


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
     * SQLized Commands
     *
     * @var array
     */
    protected $commands = [];


    /**
     * SQLize constructor.
     *
     * @param \App\Database\SQL\Blueprint $blueprint
     */
    public function __construct( Blueprint $blueprint )
    {

        global $wpdb;

        $this->wpdb = $wpdb;
        $this->blueprint = $blueprint;
        $this->collation = $blueprint->collation;

    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getCommands()
    {
        return $this->commands;
    }

    public function format()
    {
        return $this->attributes;
    }

    /**
     * Sets an attribute with a key
     *
     * @param $key
     * @param $value
     */
    protected function addAttribute( $key, $value )
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Gets the attribute from key
     *
     * @param $key
     * @return mixed
     */
    protected function getAttribute( $key )
    {
        return $this->attributes[ $key ];
    }

    protected function createSQLPrefix()
    {
        $starter = strtoupper( $this->extractMainCommand()['name'] );

        $this->addAttribute( 'prefix', $starter. " TABLE IF NOT EXISTS " . $this->blueprint->getTable() );
    }



    /**
     * Get the columns and form the sql format for it
     */
    protected function createColumns()
    {
        foreach( $this->blueprint->getColumns() as $key => $fields ){
            $this->columns[]  =  ( new Column( $fields ) )->toSQL();
        }

        $this->addAttribute( 'tables', $this->columns );

    }

    protected function createCommands()
    {
        foreach( $this->blueprint->getCommands() as $key => $fields ){
            $this->columns[]  =  ( new Column( $fields ) )->toSQL();
        }

        $this->addAttribute( 'tables', $this->columns );
    }

    /**
     * Add the suffix in the attributes
     */
    protected function createSQLSuffix()
    {
        $this->addAttribute( 'suffix', $this->collation);
    }


    /**
     * Get the main command of the blueprint
     *
     * @return mixed
     */
    protected function extractMainCommand()
    {
        return array_shift( $this->blueprint->getCommands() );
    }

    /**
     * Responsible for building the whole SQL
     */
    protected function buildSQL()
    {
        $this->createSQLPrefix();
        $this->createColumns();
//        $this->createCommands();
        $this->createSQLSuffix();

        return $this->sql = $this->attributes['prefix'] . " ( " . implode( ", ", $this->attributes[ 'tables' ] ) . " ) " . $this->attributes[ 'suffix' ];

    }

    /**
     * Formats the given array into an SQL
     *
     * @return string|array
     */
    public function toSQL()
    {
        return $this->buildSQL();
    }

}
