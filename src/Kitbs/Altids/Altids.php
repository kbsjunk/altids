<?php namespace Kitbs\Altids;

use Hashids\Hashids;

class Altids {

	/**
	 * All configurations of Hashids\Hashids currently in use.
	 *
	 * @var array
	 */
	private $hashids = [];

	/**
	 * The default Hashids configuration.
	 *
	 * @var string
	 */
	private $hashidsConfig = [];

	/**
	 * All configurations of Altids\Slugs currently in use.
	 *
	 * @var string
	 */
	private $slugs = [];

	/**
	 * The default Altids\Slugs configuration.
	 *
	 * @var string
	 */
	private $slugsConfig = [];

	/**
	 * Create a new Altids instance and collect default configuration.
	 *
	 * @return void
	 */
	public function __construct()
	{
		global $app;

		$this->hashidsConfig = $app->config->get('altids::hashids');

	}

	/**
	 * Return a new or existing instance of Hashids\Hashids with the given configuration.
	 *
	 * @var string  $salt
	 * @var int     $length
	 * @var string  $alphabet
	 * @return \Hashids\Hashids
	 */
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

	/**
	 * Return a unique string for the supplied configuration.
	 *
	 * @var mixed[] $config
	 * @return string
	 */
	private function getConfigKey(array $config) {
		return md5(serialize($config));
	}

	/**
	 * Combine the supplied configuration with the default configuration.
	 *
	 * @var string  $salt
	 * @var int     $length
	 * @var string  $alphabet
	 * @return array
	 */
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
	// public function dumpConfigs() { dd(array_keys($this->hashids)); }
}