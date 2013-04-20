<?php

// TestController.php - Example test controller
// By Anton Van Eechaute

namespace Example\ExampleBundle\Controller;

use Devine\Framework\BaseController;

class TestController extends BaseController
{
    public function indexAction()
    {
        $service = $this->sget('ExampleService');

        $this->add('param', $service->test());

        $this->setTemplate('example.index');
    }
}