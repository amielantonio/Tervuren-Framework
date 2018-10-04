<?php
namespace  App\Database\SQL;

use Closure;
use App\Database\SQL\SQLize;
use App\Database\SQL\Fluent;

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
        global $wpdb;
        $this->table = $wpdb->prefix . $table;

        $this->collation = $wpdb->get_charset_collate();

        if (! is_null($callback)) {
            $callback($this);
        }
    }

    /**
     * Check if the commands has a create command
     *
     * @return bool
     */
    public function hasCreate()
    {
        return $this->commands[0]['name'] == 'create';
    }

    public function hasDrop()
    {
        return $this->commands[0]['name'] == 'drop';
    }


    /**
     * Execute the blueprint for the database
     */
    public function create()
    {
        return $this->addCommand( 'create' );
    }

    /**
     * Returns the SQL format of the blueprint
     *
     * @return string
     */
    public function build()
    {
        return ( new SQLize( $this ) )->toSQL();
    }

    /**
     * Defines the incremental columns in the blueprint
     *
     * @param $column
     * @return string
     */
    public function increments( $column )
    {
        return $this->unsignedInteger( $column , true );
    }

    /**
     * Defines the unique columns on the blueprint
     *
     * @param $columns
     * @param null $name
     * @param null $algorithm
     * @return array
     */
    public function unique( $columns, $name = null, $algorithm = null )
    {
        return $this->indexCommand( 'unique', $columns, $name, $algorithm );
    }

    /**
     * Creates a primary key for a column on the blueprint
     *
     * @param string|array $columns
     * @param null $name
     * @param null $algorithm
     * @return array
     */
    public function primary( $columns, $name = null, $algorithm = null )
    {
        return $this->indexCommand( 'primary', $columns, $name, $algorithm );
    }

    public function nullable( $columns, $name = null, $algorithm = null )
    {
        return $this->indexCommand( 'nullable', $columns, $name, $algorithm );
    }

    /**
     * Defines a Char column on the blueprint
     *
     * @param $column
     * @param null $length
     * @return string
     */
    public function char( $column, $length = null )
    {
        $length = $length ?: $this->defaultStringLength;

        return $this->addColumn( "char", $column, compact( 'length' ) );
    }

    /**
     * Defines a string column on the blueprint
     *
     * @param $column
     * @param null $length
     * @return string
     */
    public function string( $column, $length = null )
    {
        $length = $length ?: $this->defaultStringLength;

        return $this->addColumn( "string", $column, compact( 'length' ) );
    }

    /**
     * Defines a text column on the blueprint
     *
     * @param string $column
     * @return string
     */
    public function text( $column )
    {
        return $this->addColumn( 'text', $column );
    }

    /**
     * Defines an integer column on the blueprint
     *
     * @param string $column
     * @param bool $autoIncrement
     * @param bool $unsigned
     * @return string
     */
    public function integer( $column, $autoIncrement = false, $unsigned = false )
    {
        return $this->addColumn( 'integer', $column, compact( 'autoIncrement', 'unsigned' ) );
    }

    /**
     * Defines an unsigned integer on the blueprint
     *
     * @param string $column
     * @param bool $autoIncrement
     * @return string
     */
    public function unsignedInteger($column, $autoIncrement = false)
    {
        return $this->integer($column, $autoIncrement, true);
    }

    /**
     * Defines a float column on the blueprint
     *
     * @param string $column
     * @param int $total
     * @param int $places
     * @return string
     */
    public function float( $column, $total = 8, $places = 2 )
    {
        return $this->addColumn( 'float', $column, compact( 'total', 'places' ));
    }

    /**
     * Defines a double column on the blueprint
     *
     * @param $column
     * @param null $total
     * @param null $places
     * @return string
     */
    public function double( $column, $total = null, $places = null  )
    {
        return $this->addColumn( 'double', $column, compact( 'total', 'places' ) );
    }

    /**
     * Defines a decimal column on the blueprint
     *
     * @param $column
     * @param int $total
     * @param int $places
     * @return string
     */
    public function decimal( $column, $total = 8, $places = 2 )
    {
        return $this->addColumn( 'decimal', $column, compact( 'total', 'places' ) );
    }

    /**
     * Defines a boolean column on the blueprint
     *
     * @param string $column
     * @return string
     */
    public function boolean( $column )
    {
        return $this->addColumn( 'boolean', $column);
    }


    /**
     * Defines an enum column on the blueprint
     *
     * @param string $column
     * @param array $allowed
     * @return string
     */
    public function enum( $column, array $allowed )
    {
        return $this->addColumn( 'enum', $column, compact( 'allowed' ) );
    }

    /**
     * Defines a date column on the blueprint
     *
     * @param string $column
     * @return string
     */
    public function date( $column )
    {
        return $this->addColumn( 'date', $column );
    }

    /**
     * Defines a datetime column on the blueprint
     *
     * @param string $column
     * @param int $precision
     * @return string
     */
    public function dateTime( $column, $precision = 0 )
    {
        return $this->addColumn( 'dateTime', $column, compact( 'precision' ) );
    }

    /**
     * Defines a time column on the blueprint
     *
     * @param $column
     * @param int $precision
     * @return string
     */
    public function time( $column, $precision = 0 )
    {
        return $this->addColumn( 'time', $column, compact( 'precision' ) );
    }

    /**
     * Defines a timestamp column on the blueprint
     *
     * @param $column
     * @param int $precision
     * @return string
     */
    public function timestamp( $column, $precision = 0 )
    {
        return $this->addColumn( 'timestamp', $column, compact( 'precision' ) );
    }

    /**
     * Add a new column to the blueprint
     *
     * @param $type
     * @param $name
     * @param array $parameters
     * @return string|array
     */
    public function addColumn( $type, $name, $parameters = [] )
    {
        $this->columns[] = $column = new Fluent(
            array_merge(compact('type', 'name'), $parameters)
        );

        return $column;
    }

    publiC function removeColumn()
    {
        //Todo: hmm not sure how this one goes.
    }

    /**
     * Add a new command to the Blueprint
     *
     * @param string $name
     * @param array $parameters
     * @return array
     */
    public function addCommand( $name, array $parameters = [] )
    {
        $this->commands[] = $command = $this->createCommand( $name, $parameters );

        return $command;
    }

    /**
     * Add a new index to the Blueprint
     *
     * @param string $type
     * @param string|array $columns
     * @param string $index
     * @param string|null $algorithm
     * @return array
     */
    public function indexCommand( $type, $columns, $index, $algorithm = null )
    {

        $columns = (array) $columns;

        $index = $index ?: $this->createIndexName( $type, $columns );

        return $this->addCommand(
            $type, compact( 'index', 'columns', 'algorithm' )
        );

    }

    /**
     * Create a unique index name
     *
     * @param $type
     * @param $columns
     * @return mixed
     */
    protected function createIndexName( $type, $columns )
    {
        $index = strtolower($this->table.'_'.implode('_', $columns).'_'.$type);

        return str_replace(['-', '.'], '_', $index);
    }

    public function removeCommand()
    {
        //Todo: same as with the other remove command
    }

    /**
     * create a new Fluent Command.
     *
     * @param $name
     * @param array $parameters
     * @return \App\Database\SQL\Fluent
     */
    public function createCommand( $name, array $parameters = [] )
    {
        return new Fluent(array_merge(compact('name'), $parameters));
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
