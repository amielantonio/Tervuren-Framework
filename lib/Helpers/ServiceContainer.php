<?php

namespace App\Helpers;

class ServiceContainer {

    /**
     * @var array
     */
    protected $services = [];

    /**
     * ServiceContainer constructor.
     */
    public function __construct()
    {
        $this->loadModules();
    }

    /**
     *
     */
    public function loadModules()
    {
        $this->services = [

        ];
    }

    /**
     * Add services to the container
     *
     * @param mixed ...$services
     */
    public function addServices( ...$services )
    {
        foreach( $services as $service ){
            $this->services[] = $service;
        }
    }

    /**
     * Return List of Services
     *
     * @return array
     */
    public function services()
    {
        return $this->services;
    }
}


