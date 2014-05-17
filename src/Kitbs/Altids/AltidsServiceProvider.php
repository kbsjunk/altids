<?php namespace Kitbs\Altids;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

use Kitbs\Altids\Altids;
// use Event;

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
		
		$this->app['events']->listen('eloquent.creating*', function($model)
		{

			if (@$model->hasSlug()) {
				echo('creating');
				$model->slug = $model->name;
			}

		});

		$this->app['events']->listen('eloquent.updating*', function($model)
		{

			if (@$model->hasSlug()) {
				if (@$model->getSlugs()->getConfig('on_update')) {
					echo('updating');
					$model->slug = $model->name.'up';
				}
			}

		});

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
