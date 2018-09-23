<?php
namespace  App\Database\SQL;

use Closure;
use App\Database\SQL\SQLize;

class Blueprint
{

    /**
     * The table the blueprint describes
     *
     * @var string
     */
    protected $table;

    /**
     * The columns that should be added to the table
     *
     * @var array
     */
    protected $columns = [];


    /**
     * The commands that should be run for the table
     *
     * @var array
     */
    protected $commands = [];

    /**
     * The collation that should be used for the database
     *
     * @var string
     */
    public $collation;

    /**
     * default value for the string length
     *
     * @var int
     */
    protected $defaultStringLength = 255;


    /**
     * Blueprint constructor.
     * @param $table
     * @param Closure|null $callback
     */
    public function __construct( $table, Closure $callback = null )
    {
        $this->table = $table;

        if (! is_null($callback)) {
            $callback($this);
        }

    }

    /**
     * Execute the blueprint for the database
     */
    public function build()
    {
        return new SQLize( $this->table, $this->commands, $this->columns );
    }

    public function increments( $column )
    {

    }

    public function unique( $column)
    {

    }

    public function primary( $column )
    {

    }


    public function char( $column, $length = null )
    {

    }

    public function string( $column, $length = null )
    {

    }

    public function text( $column ){

    }

    public function integer( $column, $autoIncrements = false, $unsigned = false )
    {

    }

    public function unsignedInteger( $column, $autoIncrements = false, $unsigned = false )
    {

    }

    public function float( $column, $total = 8, $places = 2 )
    {

    }

    public function double( $column, $total = null, $places = null  )
    {

    }

    public function decimal( $column, $total = 8, $places = 2 )
    {

    }

    public function boolean( $column )
    {

    }

    public function enum( $column )
    {

    }

    public function dateTime( $column )
    {

    }

    public function time( $column )
    {

    }

    public function timestamp( $column )
    {

    }

    public function date( $column )
    {

    }

    public function nullable( $column ){

    }

    public function addColumn()
    {

    }

    publiC function removeColumn()
    {

    }

    public function addCommand()
    {
        $this->commands = $commands = $this->createCommand();
    }

    public function removeCommand()
    {

    }


    public function createCommand()
    {
        return new SQLize();
    }

    /**
     * Get the table that the blueprint describes
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Get the columns on the blueprint
     *
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Get all the commands on the blueprint
     *
     * @return array
     */
    public function getCommands()
    {
        return $this->commands;
    }

}
