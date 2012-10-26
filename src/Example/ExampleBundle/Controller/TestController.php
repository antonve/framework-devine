<?php

// AirportController.php - General controller
// By Anton Van Eechaute

namespace Example\ExampleBundle\Controller;

use Devine\Framework\BaseController;

class TestController extends BaseController
{
    public function indexAction()
    {
        $as = $this->sget('ExampleService');

        echo $as->test();

        $this->setTemplate('example.index');
    }
}