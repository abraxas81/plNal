<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		'App\Http\Middleware\VerifyCsrfToken',
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => 'App\Http\Middleware\Authenticate',
		'klijentId' => '\App\Http\Middleware\HasKlijentSession',
		'ajax' => '\App\Http\Middleware\IsAjax',
		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'guest' => 'App\Http\Middleware\RedirectIfAuthenticated',
		'role' => '\Zizaco\Entrust\Middleware\EntrustRole',
		'role.canEditUser' => 'App\Http\Middleware\Admin\canEditUser',
		'permission' => '\Zizaco\Entrust\Middleware\EntrustPermission',
		'permission.canEdit' => 'App\Http\Middleware\canEdit',
		'ability' => '\Zizaco\Entrust\Middleware\EntrustAbility',
		'resetLastActive' => '\App\Http\Middleware\ResetLastActive',
	];

}
