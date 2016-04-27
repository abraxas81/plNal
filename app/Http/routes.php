<?php

use Zizaco\Entrust\EntrustServiceProvider;
use Illuminate\Support\Facades\Mail;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',['as' => 'welcome', 'uses' => 'WelcomeController@index']);

Route::get('home',['as' => 'home', 'uses' => 'HomeController@index']);

Route::group(array('namespace' => 'Klijent'), function()
{
	//rute vezane za klijent->partner->računi
	Route::get('klijenti/basic-data', 'KlijentiController@BasicData');
	Route::get('klijenti/{klijenti}/ProvjeraIbana', 'KlijentiController@ProvjeraIbana');
	Route::get('klijenti/{klijenti}/ziro/{ziro}', 'KlijentiController@DohvatiPartnera');	
	Route::get('klijenti/odaberi/{klijenti}', 'KlijentiController@OdaberiKlijenta');
	Route::resource('klijenti', 'KlijentiController');
	Route::get('klijenti/{klijenti}/partneri/basic-data', 'KlijentiPartneriController@BasicData');
	Route::get('klijenti/{klijenti}/partneri/dohvatiPartnera', 'KlijentiPartneriController@DohvatiPartnera');
	Route::resource('klijenti.partneri', 'KlijentiPartneriController');
	Route::get('klijenti/{klijenti}/partneri/{partneri}/ziro/basic-data', 'PartneriZiroRacuniController@BasicData');
	Route::resource('klijenti.partneri.ziro', 'PartneriZiroRacuniController');
	Route::resource('klijenti.postavke', 'PostavkeController');


	Route::group(['middleware' => 'klijentId'], function(){
		//rute vezane za klijent->Predlošci->vrstaNaloga
		Route::get('klijenti/{klijenti}/predlosci/basic-data', 'PredlosciController@BasicData');
		Route::resource('klijenti.predlosci', 'PredlosciController');
		//Rute vezane za klijent->Nalog->vrstaNaloga
		Route::get('klijenti/{klijenti}/nalozi/basic-data', 'NaloziController@BasicData');
		Route::resource('klijenti.nalozi', 'NaloziController');
		//rute vezane za klijent->Zbrojni nalozi->vrstaNaloga
		Route::get('klijenti/{klijenti}/zbrojniNalog/basic-data', 'ZbrojniNalogController@BasicData');
		Route::get('klijenti/{klijenti}/zbrojniNalog/{zbrojniNalog}/datoteka', 'ZbrojniNalogController@Datoteka');
		Route::get('klijenti/{klijenti}/zbrojniNalog/{zbrojniNalog}/predložak', 'ZbrojniNalogController@Predlozak');
		Route::resource('klijenti.zbrojniNalog', 'ZbrojniNalogController');
		//nalozi unutar zbrojnog naloga
		Route::get('klijenti/{klijenti}/zbrojniNalog/{zbrojniNalog}/nalozi/basic-data', 'ZnNaloziController@BasicData');
		Route::resource('klijenti.zbrojniNalog.nalozi', 'ZnNaloziController');
		//Predlosci u zbrojnom nalogu
		Route::get('klijenti/{klijenti}/zbrojniNalog/{zbrojniNalog}/predlosci/basic-data', 'ZnPredlosciController@BasicData');
		Route::resource('klijenti.zbrojniNalog.predlosci', 'ZnPredlosciController');
	});
});


Route::filter('SeeAdmin', function()
{
	// check the current user
	if (!Entrust::hasRole(['Admin','SuperAdmin'])) {
			Flash::error('Nemate prava vidjeti ovu stranicu');
		return Redirect::to('home');
	}
});

// only users with roles that have the 'manage_posts' permission will be able to access any admin/* route
Route::when('admin/*', 'SeeAdmin');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function(){
	Route::get('operateri/basic-data', 'UsersController@BasicData');
	Route::resource('operateri', 'UsersController');
	Route::get('uloge/basic-data', 'RolesController@BasicData');
	Route::resource('uloge', 'RolesController');
	Route::get('dozvole/basic-data', 'PermissionsController@BasicData');
	Route::resource('dozvole', 'PermissionsController');
	Route::get('postavke/basic-data', 'PostavkeController@BasicData');
	Route::resource('postavke', 'PostavkeController');
});

//Entrust::routeNeedsRole('admin/*', array('Admin','SuperAdmin'), Redirect::to('welcome'));

//Operater
Route::group(['prefix' => 'operateri'], function(){
	Route::get('postavke/basic-data', 'PostavkeController@BasicData');
	Route::resource('postavke', 'PostavkeController');
	Route::resource('operateri','Operater\UsersController');
});

Route::resource('partneri', 'PartnerController');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

/*Route::get('{view}', function($view) {
	if (view()->exists($view)) {
		return view($view);
	}

	return app()->abort(404, 'Page not found!');
});*/

Event::listen('auth.login', function($event)
{
	Log::info(Auth::user()->name. ' prijavio se u sustav');
});

Event::listen('auth.logout', function($event)
{
	Log::info(Auth::user()->name. ' odjavio se iz sustava');
});

