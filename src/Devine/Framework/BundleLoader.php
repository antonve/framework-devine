<?php

// BundleLoader.php - make php services easily available in controllers
// By Anton Van Eechaute

namespace Devine\Framework;

/**
 * A class to load bundles
 */
class BundleLoader
{
    /**
     * An array with strings that represent bundles
     * @var array
     */
    private $bundles = array();

    /**
     * An array with loaded bundles
     * @var array
     */
    private $loaded = array();

    /**
     * An array containing all the routes
     * @var array
     */
    private $routes;

    /**
     *
     * @var Collection
     */
    private $services;

    /**
     * @var BundleClassLoader
     */
    private $bundleClassLoader;

    /**
     * @param array $bundles
     * @param BundleClassLoader $bundleClassLoader
     */
    function __construct($bundles, BundleClassLoader $bundleClassLoader)
    {
        $this->bundles = $bundles;
        $this->routes = new RouteCollection();
        $this->bundleClassLoader = $bundleClassLoader;
        $this->services = new Collection();
    }

    /**
     * Load all configured bundles
     * @param $path path to where bundles live
     * @throws \Exception
     */
    public function load($path)
    {
        foreach ($this->bundles as $bundle) {
            if (file_exists($path . $bundle . '/config/config.php')) {
                $bundle = new Bundle(
                    array_merge(
                        include ($path . $bundle . '/config/config.php'),
                        array ('path' => $path . $bundle)
                    )
                );
                $bundle->load();
                $this->bundleClassLoader->register($bundle->getNamespace());

                $this->loaded[] = $bundle;
            } else {
                throw new \Exception('Bundle \'' . $path . $bundle . '\'not found.');
            }
        }
    }

    /**
     * Get all the routes, if empty get all
     * @return array
     */
    public function getRoutes()
    {
        if ($this->routes->isEmpty()) {
            foreach ($this->loaded as $bundle) {
                $this->routes->addCollection($bundle->getRoutes());
            }
        }

        return $this->routes;
    }

    /**
     * Get all services
     */
    public function getServices()
    {
        if ($this->services->isEmpty()) {
            foreach ($this->loaded as $bundle) {
                $this->services->addArray($bundle->getServices());
            }
        }

        return $this->services;
    }

}