<?php
namespace App\Database\SQL;

abstract class Column
{

    protected $name;

    protected $type;

    protected $length;

    protected $unsigned;

    protected $nullable;

    protected $autoIncrement;

    public function __construct( array $column )
    {
        $this->name = $this->extract( $column['name'] );
        $this->type = $this->extract( $column['type'] );
        $this->length = $this->extract( $column['length'] );
        $this->unsigned = $this->extract( $column['unsigned'] );
        $this->autoIncrement = $this->extract( $column[ 'autoIncrement' ] );
    }

    public function extract( $column_name )
    {
        return isset($column_name) ?: "" ;
    }


    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return mixed
     */
    public function getUnsigned()
    {
        return ($this->unsigned) ? "UNSIGNED" : "";
    }

    public function getNullable()
    {
        return ($this->nullable) ? "NOT NULL" : "NULL";
    }

    public function getAutoIncrement()
    {
        return ($this->autoIncrement) ? "AUTO_INCREMENT" : "";
    }

    public function __call($name, $arguments)
    {

    }
}
