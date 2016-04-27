<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use App\VrstaNaloga;
use App\TipParametra;
use App\ModelPlacanja;
use App\Valuta;
use App\SifraNamjene;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		if (!Cache::has("vrsteNaloga")) {
				$vrsteNaloga =  VrstaNaloga::all();
			Cache::forever("vrsteNaloga", $vrsteNaloga);
		}
		if(!Cache::has('TipPostavkeRacuni')){
			Cache::forever("TipPostavkeRacuni", TipParametra::where('NazivTipa','racuniPlacanja')->get()->first());
		}
		//if (!Cache::has("ModeliPlacanja")) {
			$ModeliPlacanja = ModelPlacanja::all();
			Cache::forever("ModeliPlacanja", $ModeliPlacanja);
		//}
		if (!Cache::has("Valute")) {
			$Valute = Valuta::all();
			Cache::forever("Valute", $Valute);
		}
		if (!Cache::has("SifreNamjene")) {
			$SifreNamjene = SifraNamjene::all();
			Cache::forever("SifreNamjene", $SifreNamjene);
		}
		View::share(['vrsteNaloga' =>  Cache::get("vrsteNaloga")] );
		View::share('gumbSpremiTxt', 'Spremi');
		View::share('gumbZatvoriTxt', 'Zatvori');
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}
