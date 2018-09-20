<?php

namespace App\Database\Builder;

/**
 * Class DataWrapper
 *
 * A $wpdb class wrapper, for more Object Oriented approach for the MVC Pattern
 *
 * @package App\Database\Builder
 */
abstract class DataWrapper{


    protected $table;

    protected $primary_key;

    protected $foreign_key;

    protected $where;


    public function get(){

    }

    public function select(){

    }

    public function getAll(){

    }

    public function first(){

    }

    public function last(){

    }

    public function save(){

    }

    public function insertOrReplace(){

    }

    public function delete(){

    }

    public function update(){

    }








}
