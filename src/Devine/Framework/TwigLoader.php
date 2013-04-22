<?php

namespace Devine\Framework;

class TwigLoader implements TemplateLoader
{
	private $loaders = array();
	private $twig;
	private $cache_path;
	private $vars = array();
	private $dev;

	function __construct($mode, $default_path, $cache_path = '')
	{
		$this->dev = $mode;
		$this->loaders[] = new \Twig_Loader_Filesystem($default_path);
		$this->cache_path = $cache_path;
	}

	public function initialize()
	{
		$opts = $this->dev ? array() : array('cache' => $this->cache_path);
		$loader = new \Twig_Loader_Chain($this->loaders);
		$this->twig = new \Twig_Environment($loader, $opts);

		return $this;
	}

	public function addTemplateDir($path)
	{
		$this->loaders[] = new \Twig_Loader_Filesystem($path);
	}

	public function assign($key, $val)
	{
		$this->vars[$key] = $val;
	}

	public function get()
	{
		return $this->twig;
	}

	public function render($template)
	{
		echo $this->twig->render($template, $this->vars);
	}
}