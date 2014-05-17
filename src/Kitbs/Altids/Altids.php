<?php namespace Kitbs\Altids;

use Hashids\Hashids;

class Altids {

	private $hashids;
	private $hashidsConfig;
	private $lastHashidsConfig;

	private $slugs;
	private $slugsConfig;

	public function __construct()
	{
		global $app;

		$this->lastHashidsConfig = $this->hashidsConfig = $app->config->get('altids::hashids');

		$this->hashids($this->hashidsConfig);

	}

	public function hashids($salt = false, $length = false, $alphabet = false)
	{
		if (is_array($salt) && !$length && !$alphabet) {
			$config = $salt;
		}
		else {
			$config = compact('salt', 'length', 'alphabet');
		}

		$config = $this->getHashidsConfig($config);

		if ($config !== $this->lastHashidsConfig) {

			extract($config);

			$this->hashids = new Hashids($salt, $length, $alphabet);
			$this->lastHashidsConfig = $config;

		}

		return $this->hashids;
	}

	private function getHashidsConfig($config)
	{
		$override = array_filter($config);

		$config = $this->hashidsConfig;
var_dump(array_merge($config, $override));
		return array_merge($config, $override);
	}


}