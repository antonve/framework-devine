#Services
A dependency injection container for controllers.

##Defining services
Every module can define services. This is done in the config file. (bundle/config/config.php) 

Example configuration:

	<?php

	return array(
    	'namespace' => 'Devine',
	    'name'      => 'UserBundle',
    	'routes'    => true,
	    'init'      => true,
    	'templating'    => true,
	    'services'  => array(
	    	array (
    	    	'name' => 'ExampleService',
	        	'class' => '\Example\ExampleBundle\Services\ExampleService',
	        	'config' => array('ExampleParam' => 'ExampleValue'),
        	),
    	),
	);
	
Every service needs a name, class path (namespace + classname) and optionally can configure some variables.

##Using services
Using `$this->sget('servicename')` you can retrieve configured services which you can later use like any other php object.

Example:
	
	<?php
	namespace Example\ExampleBundle\Controller;

	use Devine\Framework\BaseController;

	class TestController extends BaseController
	{
    	public function indexAction()
    	{
    	    $service = $this->sget('ExampleService');
    	}
	}