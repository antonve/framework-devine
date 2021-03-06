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
use Devine\Framework\TwigLoader;

// load helpers
require_once ($project_dir . 'src/Devine/Framework/helpers.php');

// configure autoloader
require_once $project_dir . 'vendor/autoload.php';

// start session
session_start();

// load general config file
$config = include('config/config.php');

// configure templating engine
$templateLoader = new TwigLoader($config['dev'], $project_dir . 'app/templates', $project_dir . 'app/cache');
$templateLoader->addTemplateDir($project_dir . 'src/Devine/Framework/templates/');

// try to build the page
try {

    // load modules
    $bundleLoader = new BundleLoader(include('config/bundles.php'), $templateLoader);
    $bundleLoader->load($project_dir . 'src/');

    // build Request object
    $request = new Request();
    // load routes & look for a match
    $urlMatcher = new UrlMatcher($bundleLoader->getRoutes(), $request);
    $route = $urlMatcher->match();
    
    // configure database
    SingletonPDO::setConfig(include('config/database.php'));

    // execute the controller and receive the response
    $controllerResolver = new ControllerResolver($route, $request, $templateLoader);
    $response = $controllerResolver->resolve($bundleLoader->getServices());
    
    // configure templating
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
    $response = new Response($templateLoader, $request);
    $response->setStatusCode(404);
    
    // configure database
    SingletonPDO::setConfig(include('config/database.php'));
    
    // configure templating
    $response->setTemplate('error404.twig');
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
    $response = new Response($templateLoader, $request);
    $response->setData(array('error' => $e->getMessage(), 'trace' => $trace));
    $response->setStatusCode(500);
    
    // configure templating
    $response->setTemplate('error500.twig');
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