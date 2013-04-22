<?php

namespace Devine\Framework;

interface TemplateLoader
{
	function __construct($mode, $default_path, $cache_path = '');

	function initialize();

	function addTemplateDir($path);

	function assign($key, $val);

	function get();

	function render($template);

}