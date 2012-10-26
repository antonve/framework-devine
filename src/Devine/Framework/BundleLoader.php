<?php

// ModuleLoader.php - make php services easily available in controllers
// By Anton Van Eechaute

namespace Devine\Framework;

class ModuleLoader
{
    private $modules = array();
    private $loaded = array();

    function __construct($modules)
    {
        $this->modules = $modules;
    }

    public function load($path)
    {
        foreach ($this->modules as $module) {
            trace($module);
            if (file_exists($path . $module . '/config/config.php')) {
                $this->loaded[] = (new Module(
                    include ($path . $module . '/config/config.php')
                ))->load();
            } else {
                throw new \Exception('Module \'' . $path . $module . '\'not found.');
            }
        }
    }

}