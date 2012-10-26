<?php

// Injectable.php - make php services easily available in controllers
// By Anton Van Eechaute

namespace Devine\Framework;

class Injectable
{
    private $services = array();

    public function sget($name)
    {
        if (array_key_exists($name, $this->services)) {
            return $this->services[$name];
        }

        throw new \Exception('Service \'' . $name . '\' not loaded.');
    }

    public function register($services)
    {
        foreach ($services->getCollection() as $service) {
            if (!$this->isValid($service)) {
                throw new \Exception('Invalid service');
            }

            $this->services[$service['name']] = new $service['class']($service['config']);
        }
    }

    public function isValid($service)
    {
        if (array_key_exists('name', $service)
            && array_key_exists('class', $service)
            && array_key_exists('config', $service)) {
            return true;
        }

        return false;
    }
}