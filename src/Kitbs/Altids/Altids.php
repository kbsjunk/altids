<?php namespace Kitbs\Altids;

use Kitbs\Altids\Hashids;
use Kitbs\Altids\Slugs;

class Altids {

	/**
	 * All configurations of Hashids\Hashids currently in use.
	 *
	 * @var array
	 */
	private $hashids = [];

	/**
	 * All configurations of Altids\Slugs currently in use.
	 *
	 * @var string
	 */
	private $slugs = [];

	/**
	 * The default configurations.
	 *
	 * @var string
	 */
	private $config = [];

	/**
	 * Create a new Altids instance and collect default configuration.
	 *
	 * @return void
	 */
	public function __construct()
	{
		global $app;
		
		$this->config['hashids'] = $app->config->get('altids::hashids');
		$this->config['slugs']   = $app->config->get('altids::slugs');

	}

	/**
	 * Return a new or existing instance of \Altids\Hashids with the given configuration.
	 *
	 * @var mixed[]  $config
	 * @return \Altids\Hashids
	 */
	public function hashids(array $config = array())
	{

		$config = $this->getConfig('hashids', $config);
		$key = $this->getConfigKey($config);

		if (!isset($this->hashids[$key])) {

			$this->hashids[$key] = new Hashids($config);

		}

		return $this->hashids[$key];
	}

	/**
	 * Return a new or existing instance of \Altids\Slugs with the given configuration.
	 *
	 * @var mixed[]  $config
	 * @return \Altids\Slugs
	 */
	public function slugs(array $config = array())
	{

		$config = $this->getConfig('slugs', $config);
		$key = $this->getConfigKey($config);

		if (!isset($this->slugs[$key])) {

			$this->slugs[$key] = new Slugs($config);

		}

		return $this->slugs[$key];
	}

	/**
	 * Return a unique string for the supplied configuration.
	 *
	 * @var mixed[] $config
	 * @return string
	 */
	private function getConfigKey($config = array()) {
		return md5(serialize($config));
	}

	/**
	 * Combine the supplied configuration with the default configuration.
	 *
	 * @var string   $altid
	 * @var mixed[]  $config
	 * @return array
	 */
	private function getConfig($altid, array $config)
	{

		$override = array_filter($config);

		$config = $this->config[$altid];

		return array_merge($config, $override);
	}

	public function dumpConfigs() { dd(array_keys($this->hashids)); }
}