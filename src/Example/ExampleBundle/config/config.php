<?php

// config.php - ExampleBundle configuration
// By Anton Van Eechaute

return array(
    'namespace' => 'Example',
    'name'      => 'ExampleBundle',
    'routes'    => true,
    'init'      => false,
    'smarty'    => true,
    'services'  => array(
         array (
        'name' => 'ExampleService',
        'class' => '\Example\ExampleBundle\Services\ExampleService',
        'config' => array('ExampleParam' => 'Hello world!'),
        ),
    ),
);