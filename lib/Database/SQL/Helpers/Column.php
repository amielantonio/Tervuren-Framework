<?php
namespace App\Database\SQL\Helpers;

class Column
{
    /**
     * Defines the current SQL for the column
     *
     * @var string
     */
    protected $sql;

    /**
     * base column definition
     *
     * @var array
     */
    protected $column = [];


    /**
     * Column Name
     *
     * @var string
     */
    protected $name;


    /**
     * Column Type
     *
     * @var string
     */
    protected $type;

    /**
     * Column Length
     *
     * @var
     */
    protected $length;


    public function __construct( $column )
    {
        $this->column = $column;

        //Build the SQL on instantiation
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
        if( isset( $this->column[ $column_name ] ) ){

            $method = 'get' . ucfirst( $column_name );

            return $this->$method();

        }

        return "";

    }


    public function getName()
    {

        return $this->name = $this->column['name'];

    }

    public function getType()
    {
        return $this->type = $this->column[ 'type'  ];
    }

    public function getLength()
    {
        return $this->length = $this->column[ 'length' ];
    }


    protected function compiledType()
    {
        if( $this->length <> "" ){

            return "{$this->type}({$this->length})";

        }

        return $this->type;

    }


    protected function build()
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
