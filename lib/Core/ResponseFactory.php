<?php

namespace App\Core;

class ResponseFactory
{

    private $response;

    public function __construct($response)
    {
        $this->response = $response;
    }


    public function toArray()
    {

    }

    public function json()
    {

    }


}