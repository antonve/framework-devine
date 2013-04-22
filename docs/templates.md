#Templating
Twig is set as the default templating engine, please take a look at the official twig docs for anything twig related.

## Using a different templating engine
Create a new class which implements the `TemplateLoader` interface and load it in the `bootstrap.php` file.

##Set the template to render
In your controller use `$this->setTemplate('templatename.twig')`.

Example: 

	<?php
	namespace Example\ExampleBundle\Controller;

	use Devine\Framework\BaseController;

	class TestController extends BaseController
	{
    	public function indexAction()
    	{
    	    $this->setTemplate('example.index.twig');
    	}
	}


