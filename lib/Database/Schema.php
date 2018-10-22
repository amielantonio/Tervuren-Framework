<?php
namespace App\Database;

use Closure;
use App\Helpers\Func;
use App\Database\Database;
use App\Database\SQL\Blueprint;

/**
 *
 *
 * Class Schema
 * @package App\Database
 */
class Schema {

    protected $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public static function create( $table, Closure $callback )
    {
        $self = new Schema();

        $self->build( (new Func)->call( $self->createBlueprint( $table ), function( $blueprint ) use( $callback ){
            $blueprint->create();

            $callback($blueprint);
        }));
    }

    /**
     * Runs the building process against the SQL database
     *
     * @param Blueprint $blueprint
     */
    protected function build( Blueprint $blueprint )
    {
        $this->database->run( $blueprint->build() );
    }

    public function dropTable()
    {

    }

    public function dropIfExists()
    {

    }

    /**
     * Create a new Blueprint
     *
     * @param $table
     * @param Closure|null $callback
     * @return Blueprint
     */
    protected function createBlueprint( $table, Closure $callback = null )
    {
        return new Blueprint( $table, $callback );
    }


}
