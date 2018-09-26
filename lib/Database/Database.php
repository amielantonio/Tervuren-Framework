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
     * @var string
     */
    public $tables;

    /**
     * The database Folder
     *
     * @var string
     */
    protected $database_folder;


    public function __construct()
    {
        $this->database_folder = s_db_path."/tables";
    }

    public function install()
    {

    }

    public function uninstall()
    {

    }

    protected function iterator( $method )
    {
        foreach( glob( $this->database_folder."/*.php") as $file ){

            require_once $file;

            $class = basename( $file, '.php' );

            if( class_exists( $class))
            {
                $obj = new $class;

                if( method_exists( $obj, $method ) ){
                    $obj->$method();
                }
            }

        }
    }

    protected function saveMigrations( $table, $method )
    {

    }

    /**
     * Get the tables of the current migration
     *
     * @return string
     */
    public function getTables()
    {
        return $this->tables;
    }
}
