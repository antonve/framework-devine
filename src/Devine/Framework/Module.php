<?php

// Module.php - represents a module
// By Anton Van Eechaute

namespace Devine\Framework;

class Module
{
    private $services = array();
    private $config = array();

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function load()
    {
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