<?php

namespace Example\ExampleBundle\Services;

class ExampleService extends \Devine\Framework\Service
{
    public function test()
    {
        return $this->config['ExampleParam'];
    }
}