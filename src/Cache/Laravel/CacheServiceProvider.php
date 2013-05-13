<?php 

namespace Cache\Laravel;

use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
        $factory = $this->app['db'];
        $factory->extend('odbc', function($config)
        {
			if(!isset($config['prefix']))
			{
				$config['prefix'] = '';
			}

            $connector =  new CacheConnector();
			$pdo = $connector->connect($config);
            return new CacheConnection($pdo, $config['database'], $config['prefix']);

		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
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