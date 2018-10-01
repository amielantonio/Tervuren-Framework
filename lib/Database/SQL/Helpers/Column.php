<?php
namespace App\Database\SQL\Helpers;

class Column
{
    /**
     * Name of the Column
     *
     * @var string
     */
    protected $name;

    /**
     * type of the Column
     *
     * @var string
     */
    protected $type;

    /**
     * Length of the specified type
     *
     * @var string
     */
    protected $length;

    /**
     * Define column as unsigned
     *
     * @var string
     */
    protected $unsigned;

    /**
     * Define column as nullable
     *
     * @var string
     */
    protected $nullable;

    /**
     * Define column as auto increment
     *
     * @var string
     */
    protected $autoIncrement;

    /**
     * Define column constraints
     *
     * @var string
     */
    protected $constraints;


    /**
     * Defines the current SQL for the column
     *
     * @var string
     */
    protected $sql;


    /**
     * Store attributes
     *
     * @var array
     */
    protected $attributes = [];



    public function __construct( $column )
    {
        $this->attributes[ 'name' ] = $this->name = $this->extract( $column['name'] );
        $this->attributes[ 'type' ] = $this->type = $this->extract( $column['type'] );
        $this->attributes[ 'length' ] = $this->length = $this->extract( $column['length'] );
        $this->attributes[ 'unsigned' ] = $this->unsigned = $this->extract( $column['unsigned'] );
        $this->attributes[ 'autoIncrement' ] = $this->autoIncrement = $this->extract( $column[ 'autoIncrement' ] );

        $this->build();
    }

    /**
     * returns the column value or a null value;
     *
     * @param $column_name
     * @return string
     */
    public function extract( $column_name )
    {
        return isset($column_name) ? $column_name : "" ;
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



    protected function build()
    {
        $length = ( $this->length <> "" ) ? "({$this->length})" : "";

        $this->sql = "{$this->name} {$this->type}{$length} {$this->nullable} {$this->autoIncrement} {$this->unsigned}";

    }


    protected function modify( $column, $modifier )
    {

    }

    /**
     * Return sql
     *
     * @return string
     */
    public function toSQL()
    {
        return $this->sql;
    }

    /**
     * Return sql;
     *
     * @return string
     */
    public function __toString()
    {
        return $this->sql;
    }
}
