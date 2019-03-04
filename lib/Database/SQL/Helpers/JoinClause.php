<?php

namespace App\Database\SQL\Helpers;

use App\Database\SQL\Helpers\Query;
use Closure;


class JoinClause extends Query
{
    public $type;

    public $table;

    private $parentQuery;

    public function __construct( Query $parentQuery, $type, $table )
    {
        $this->type = $type;
        $this->table = $table;
        $this->parentQuery = $parentQuery;

        parent::__construct();
    }

    /**
     * @param $first
     * @param null $operator
     * @param null $second
     * @param string $link
     * @return Query|JoinClause|array
     * @throws \Exception
     */
    public function on( $first, $operator = null, $second = null, $link = "and")
    {

        if( $first instanceof Closure) {
            return $this->nestedWhere( $first );
        }

        return $this->whereColumn( $first, $operator, $second, $link );

    }

    /**
     * @param $first
     * @param null $operator
     * @param null $second
     * @param string $link
     * @return Query|JoinClause|array
     * @throws \Exception
     */
    public function orOn( $first, $operator = null, $second = null, $link = "or" )
    {
        return $this->on( $first, $operator, $second, $link );
    }


}
