<?php
namespace App\Database;

use DirectoryIterator;
use App\Settings\Settings;
use App\Database\Builder\DataWrapper;

/**
 * Responsible for installing database tables to the network
 *
 * Class Database
 * @package App\Database
 */
class Database extends DataWrapper {

    /**
     * List of all tables
     *
     * @var array
     */
    public $tables = [];

    /**
     * The database Folder
     *
     * @var string
     */
    protected $database_folder;


    /**
     * Creating a wpdb instance;
     *
     * @var \wpdb
     */
    protected $query;


    /**
     * Database constructor.
     */
    public function __construct()
    {
        global $wpdb;

        $this->query = $wpdb;

        $this->database_folder = S_DBPATH."/tables";

    }

    /**
     * Run Database installation
     */
    public function install()
    {
        $this->iterator( 'up' );
    }

    /**
     * Responsible for running the sql
     *
     * @param string;
     * @return string | boolean;
     */
    public function run( $sql )
    {
        return $this->query->query( $sql );
    }

    /**
     * Call all the tables classes to start installing the database
     *
     * @param $method
     */
    protected function iterator( $method )
    {
        foreach( glob( $this->database_folder."/*.php") as $file ){

            require_once $file;

            $class = basename( $file, '.php' );

            if( class_exists( $class) )
            {
                $obj = new $class;

                if( method_exists( $obj, $method ) ){
                    $obj->$method();
                }
            }
        }
    }


    /**
     * @param string|array $tables
     * @param $method
     *
     * @return string|array
     */
    protected function saveMigrations( $tables, $method )
    {
        $this->tables[] = $table = $tables;

        return $table;
    }

    /**
     * Get the tables of the current migration
     *
     * @return array
     */
    public function getTables()
    {
        return $this->tables;
    }
}
