<?php namespace VivifyIdeas\AdminPanelGenerator\Providers;

use Illuminate\Support\ServiceProvider;

require __DIR__.'/../../vendor/autoload.php';

class AdminPanelGeneratorProvider extends ServiceProvider {

	const PACKAGE_NAME = 'vivifyideas/admin-panel-generator';
	const PACKAGE_NAME_CONFIG = 'vivifyideas.admin-panel-generator';

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->loadViewsFrom(__DIR__.'/../../resources/views', self::PACKAGE_NAME);

		$this->publishes([
			__DIR__ . '/../../config/' . self::PACKAGE_NAME . '.php' => config_path(self::PACKAGE_NAME . '.php'),
		]);

		include __DIR__.'/../helpers.php';
		include __DIR__.'/../routes.php';
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->register('Illuminate\Html\HtmlServiceProvider');

		$loader = \Illuminate\Foundation\AliasLoader::getInstance();
		$loader->alias('HTML', 'Illuminate\Html\HtmlFacade');
		$loader->alias('Form', 'Illuminate\Html\FormFacade');
	}

}
