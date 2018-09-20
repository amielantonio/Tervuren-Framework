<?php
namespace  App\Database\Grammar;

use Closure;

class Blueprint
{

    protected $table;

    protected $column = [];

    protected $commands = [];


    public function __construct( $table, Closure $callback = null )
    {
        $this->table = $table;

        if (! is_null($callback)) {
            $callback($this);
        }

    }

    public function integer( $column )
    {
        return "integer {$column}";
    }

    public function string( $column, $length )
    {
        return "string {$column} {$length}";
    }

    public function increments( $column )
    {

        return "increments {$column}";

    }

    public function unique( $column)
    {

        return "unique {$column}";

    }

}
