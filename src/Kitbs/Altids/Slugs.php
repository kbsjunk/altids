<?php namespace Kitbs\Altids;

class Slugs {

	private $config = [];

	public function __construct($config = array())
	{
		$this->config = $config;
	}

	public function getConfig($key = false)
	{
		if ($key) {
			return array_get($this->config, $key);
		}

		return $this->config;
	}
	
}