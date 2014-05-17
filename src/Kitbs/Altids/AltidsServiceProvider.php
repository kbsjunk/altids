<?php namespace Kitbs\Altids;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

use Kitbs\Altids\Altids;

class AltidsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->package('kitbs/altids');

		$this->app->singleton('altids', function()
		{
			return new Altids();
		});

		$loader = AliasLoader::getInstance();

		$loader->alias('Altids', 'Kitbs\Altids\Facades\AltidsFacade');
		$loader->alias('Hashids', 'Kitbs\Altids\Traits\HashidsTrait');
		$loader->alias('Slugs', 'Kitbs\Altids\Traits\SlugsTrait');
		

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
