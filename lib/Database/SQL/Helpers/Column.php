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
     * @var integer
     */
    protected $length;

    /**
     * Column Definition for constraints
     *
     * @var array
     */
    protected $constraints = [];

    /**
     * Column constructor.
     * @param $column
     */
    public function __construct( $column )
    {
        $this->column = $column;

        $this->name = $this->extract( 'name' );
        $this->type = $this->extract( 'type' );
        $this->length = $this->extract( 'length' );

        //Register Constraints
        $this->constraints[] = $this->extract( 'unsigned' );
        $this->constraints[] = $this->extract( 'autoIncrements' );

        $this->constraints[] = $this->extract( 'nullable' );
        $this->constraints[] = $this->extract( 'unique' );
        $this->constraints[] = $this->extract( 'primary' );
        $this->constraints[] = $this->extract( 'default' );

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
        return $this->column['name'];
    }

    public function getType()
    {
        if( $this->column['type'] == "string") {
            return "varchar";
        }else{
            return $this->column[ 'type'  ];
        }
    }

    public function getLength()
    {
        return $this->column[ 'length' ];
    }

    public function getNullable()
    {
        return $this->column['nullable'] ? "NULL" : "NOT NULL";
    }

    protected function getPrimary()
    {
        return $this->column[ 'primary' ] ? "PRIMARY KEY" : "";
    }

    protected function getUnique()
    {
        return $this->column[ 'unique' ] ? "UNIQUE" : "";
    }

    public function getConstraints()
    {
        return $this->constraints;
    }

    public function getUnsigned()
    {
        return $this->column['unsigned'] ? "UNSIGNED" : "";
    }

    public function getAutoIncrements()
    {
        return $this->column['autoIncrements'] ? "AUTO_INCREMENT" : "";
    }

    public function getDefault()
    {
        return isset($this->column['default']) ? "DEFAULT '{$this->column['default']}'" : "";
    }

    protected function compiledType()
    {
        if( $this->length <> "" ){

            return "{$this->type}({$this->length})";

        }

        return $this->type;
    }

    protected function compiledConstraints()
    {
        return implode( ' ', $this->constraints );
    }


    protected function build()
    {
        //Add column name
        $this->sql .= $this->name." ";

        //Add column type
        $this->sql.= $this->compiledType()." ";

        //Add constraints
        $this->sql .= $this->compiledConstraints();

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
