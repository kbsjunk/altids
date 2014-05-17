<?php namespace Kitbs\Altids;

use Kitbs\Altids\Hashids;
use Kitbs\Altids\Slugs;

class Altids {

	/**
	 * All configurations of Altids\Hashids and Altids\Slugs currently in use.
	 *
	 * @var array
	 */
	private $configs = [];

	/**
	 * The default configurations for Altids\Hashids and Altids\Slugs.
	 *
	 * @var string
	 */
	private $defaults = [];

	/**
	 * Create a new Altids instance and collect default configuration.
	 *
	 * @return void
	 */
	public function __construct()
	{
		global $app;
		
		$this->defaults['hashids'] = $app->config->get('altids::hashids');
		$this->defaults['slugs']   = $app->config->get('altids::slugs');

	}

	/**
	 * Return a new or existing instance of \Altids\Hashids with the given configuration.
	 *
	 * @var mixed[]  $config
	 * @return \Altids\Hashids
	 */
	public function hashids(array $config = array())
	{
		return $this->getConfigInstance('hashids', $config);
	}

	/**
	 * Return a new or existing instance of \Altids\Slugs with the given configuration.
	 *
	 * @var mixed[]  $config
	 * @return \Altids\Slugs
	 */
	public function slugs(array $config = array())
	{
		return $this->getConfigInstance('slugs', $config);
	}

	private function getConfigInstance($altid, array $config)
	{
		$config = $this->getConfig($altid, $config);
		
		$key = $this->getConfigKey($config);

		if (!isset($this->configs[$altid][$key])) {

			$this->configs[$altid][$key] = new Slugs($config);

		}

		return $this->configs[$altid][$key];
	}

	/**
	 * Return a unique string for the supplied configuration.
	 *
	 * @var mixed[] $config
	 * @return string
	 */
	private function getConfigKey($config = array())
	{
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

		$config = $this->defaults[$altid];

		return array_merge($config, $override);
	}

	public function dumpConfigs() { echo '<pre>'; dd($this->configs); }
}