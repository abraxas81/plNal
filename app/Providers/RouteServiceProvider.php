<?php namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider {

	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router)
	{
		//
		
		parent::boot($router);

		$router->model('klijenti', 'App\Klijent');
		$router->model('partneri', 'App\Partner');
		$router->model('ziro', 'App\ZiroRacun');
		$router->model('predlosci', 'App\Predlozak');
		$router->model('zbrojniNalog', 'App\ZbrojniNalog');
		$router->model('vrsteNaloga', 'App\VrstaNaloga');
		$router->model('operateri', 'App\User');
		$router->model('dozvole', 'App\Permission');
		$router->model('uloge', 'App\Role');
		$router->model('nalozi', 'App\Nalog');
		$router->model('postavke', 'App\Parametar');
	}

	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function map(Router $router)
	{
		$router->group(['namespace' => $this->namespace], function($router)
		{
			require app_path('Http/routes.php');
		});
	}

}
