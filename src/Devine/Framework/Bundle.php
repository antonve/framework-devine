<?php

// Module.php - represents a module
// By Anton Van Eechaute

namespace Devine\Framework;

class Module
{
    private $config;
    private $routes;
    private $smarty;
    private $services;


    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function load()
    {
        return $this;
    }

    public function isValid($module)
    {
        if (array_key_exists('name', $module)
            && array_key_exists('services', $module)
            && array_key_exists('init', $module)
            && array_key_exists('routes', $module)
            && array_key_exists('smarty', $module)) {
            return true;
        }

        return false;
    }
}