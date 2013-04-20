<?php

// bootstrap.php - Bootstrapping the application
// By Anton Van Eechaute

use Devine\Framework\Request;
use Devine\Framework\Response;
use Devine\Framework\UrlMatcher;
use Devine\Framework\ControllerResolver;
use Devine\Framework\PageNotFoundException;
use Devine\Framework\SingletonPDO;
use Devine\Framework\BundleLoader;

// load helpers
require_once ($project_dir . 'src/Devine/Framework/helpers.php');

// configure autoloader
require_once $project_dir . 'vendor/autoload.php';

// start session
session_start();

// load general config file
$config = include('config/config.php');

// configure smarty templating engine
include('config/smarty.php');

// try to build the page
try {

    // load modules
    $bundleLoader = new BundleLoader(include('config/bundles.php'), $smarty);
    $bundleLoader->load($project_dir . 'src/');

    // build Request object
    $request = new Request();
    // load routes & look for a match
    $urlMatcher = new UrlMatcher($bundleLoader->getRoutes(), $request);
    $route = $urlMatcher->match();
    
    // configure database
    SingletonPDO::setConfig(include('config/database.php'));

    // execute the controller and receive the response
    $controllerResolver = new ControllerResolver($route, $request, $smarty);
    $response = $controllerResolver->resolve($bundleLoader->getServices());
    
    // configure templating
    $response->setLayout($project_dir . 'app/templates/layout.tpl');
    $response->setRoot($request->getRoot());
    $response->setRootDir(dirname($request->getRoot()));
    $response->setDevelopmentMode($config['dev']);

    foreach($bundleLoader->getInitPaths() as $path) {
        include ($path);
    }
}

// handle error 404's
catch (PageNotFoundException $e) {
    // build Request object
    $request = new Request();
    
    // build new Response object
    $response = new Response($smarty, $request);
    $response->setStatusCode(404);
    
    // configure database
    SingletonPDO::setConfig(include('config/database.php'));
    
    // configure templating
    $response->setLayout($project_dir . 'app/templates/layout.tpl');
    $response->setTemplate('error404');
    $response->setRoot($request->getRoot());
    $response->setRootDir(dirname($request->getRoot()));
    $response->setDevelopmentMode($config['dev']);
}

// handle all other errors
catch (Exception $e) {
    // build stack trace
    $trace = array_merge(array(array('file' => $e->getFile(), 'line' => $e->getLine())), $e->getTrace());
    
    // build Request object
    $request = new Request();
    
    // configure database
    SingletonPDO::setConfig(include('config/database.php'));
    
    // build new Response object
    $response = new Response($smarty, $request);
    $response->setData(array('error' => $e->getMessage(), 'trace' => $trace));
    $response->setStatusCode(500);
    
    // configure templating
    $response->setLayout($project_dir . 'app/templates/layout.tpl');
    $response->setTemplate('error500');
    $response->setRoot($request->getRoot());
    $response->setRootDir(dirname($request->getRoot()));
    $response->setDevelopmentMode($config['dev']);
}
    
// send the response
$ajax = false;
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $ajax = true;
}

$response->send($ajax);