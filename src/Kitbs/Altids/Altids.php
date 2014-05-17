<?php namespace Kitbs\Altids;

use Hashids\Hashids;

class Altids {

	private $hashids = [];
	private $hashidsConfig = [];

	private $slugs = [];

	public function __construct()
	{
		global $app;

		$this->hashidsConfig = $app->config->get('altids::hashids');

	}

	public function hashids($salt = '', $length = 0, $alphabet = '')
	{

		$config = $this->getHashidsConfig($salt, $length, $alphabet);
		$key = $this->getConfigKey($config);

		if (!isset($this->hashids[$key])) {

			extract($config);
			$this->hashids[$key] = new Hashids($salt, $length, $alphabet);

		}

		return $this->hashids[$key];
	}

	private function getConfigKey($config) {
		return md5(serialize((array) $config));
	}

	private function getHashidsConfig($salt = false, $length = false, $alphabet = false)
	{

		if (is_array($salt) && !$length && !$alphabet) {
			$config = $salt;
		}
		else {
			$config = compact('salt', 'length', 'alphabet');
		}

		$override = array_filter($config);

		$config = $this->hashidsConfig;

		return array_merge($config, $override);
	}


}