<?php

namespace App\Http\Controllers\Klijent;

use App\Klijent;
use App\Nalog;
use App\ZbrojniNalog;
use App\Parametar;
use App\ZiroRacun;

//zajedničko za sve controllere
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Laracasts\Flash\Flash;
use App\Services\PorukeOperaterima;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;


class PredlozakNaloziController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
        $this->middleware('ajax',['only' => 'show']);

        //['key'] => ['displayTitle',position, 'visible','searchable', 'orderable']
        $tabelaStupci = [
            ['platitelj.IBAN','platitelj.IBAN','Iban Platitelja',0,true,true,true],
            ['model_odobrenja.Vrijednost','modelOdobrenja.Vrijednost','Model Odobrenja',1,true,true,true],
            ['BrojOdobrenja','Nalozi.BrojOdobrenja','Broj Odobrenja',2,true,true,true],
            ['primatelj.IBAN','primatelj.IBAN','Iban primatelja',3,true,true,true],
            ['model_zaduzenja.Vrijednost','modelZaduzenja.Vrijednost','Model Zaduženja',4,true,true,true],
            ['BrojZaduzenja','Nalozi.BrojZaduzenja','Broj Zaduženja',5,true,true,true],
            ['Iznos','Nalozi.Iznos','Iznos',6,true,true,true],
            ['Opis','Nalozi.Opis','Opis',7,true,true,true],
            ['datumizvrsenja','Nalozi.datumizvrsenja','Datum Izvršenja',8,true,true,true],
            ['valute.Alfa','valute.Alfa','Valuta',9,true,false,false],
            ['action','Akcije','Akcije',10,true,false,false]
        ];

        $tabelaStupci2 = [
            //['prid','Predlosci.prid','ID', 0,1,0,1],
            ['Naziv','Predlosci.Naziv','Naziv Predloška',0,true,true,true],
            ['platitelj.IBAN','platitelj.IBAN','Iban Platitelja',1,true,true,true],
            ['model_odobrenja.Vrijednost','modelOdobrenja.Vrijednost','Model Odobrenja',2,true,true,true],
            ['BrojOdobrenja','Predlosci.BrojOdobrenja','Broj Odobrenja',3,true,true,true],
            ['primatelj.IBAN','primatelj.IBAN','Iban Primatelja',4,true,true,true],
            ['model_zaduzenja.Vrijednost','modelZaduzenja.Vrijednost','Model Zaduženja',5,true,true,true],
            ['BrojZaduzenja','Predlosci.BrojZaduzenja','Broj Zaduženja',6,true,true,true],
            ['Iznos','Predlosci.Iznos','Iznos',7,true,true,true],
            ['Opis','Predlosci.Opis','Opis',8,true,true,true],
            ['valute.Alfa','valute.Alfa','Valuta',9,true,false,false],
            ['action','Akcije','Akcije',10,true,false,false]
        ];

        view()->share('description', $this->getDescription('Predlosci'));
        view()->share('title', $this->getTitle('Zbrojni nalog'));

        //definiram koja se postavka koristi ovdje
        $tipPostavke =  Cache::get('TipPostavkeRacuni');
        //provjeravam da li klijent već ima neke postavke
        $parametriPlatitelj = Parametar::where('KlijentiId',Session::get('klijentId'))->where('TipParametraId',$tipPostavke->id)->first();
        //ako si je odabrao s kojih će računa plaćati odabire se smanjeni broj računa u selectu
        if($parametriPlatitelj){
            Cache::forever(Session::get('klijentId') . "Platitelji", ZiroRacun::whereIn('id',$parametriPlatitelj->Vrijednost)->with('partneri')->get());
        }else{
            ZiroRacun::with(['partneri','partneri.klijenti' => function($q){$q->where('Klijenti_id',Session::get('klijentId'));}])->get();
            /*if (!Cache::has(Session::get('klijentId')."Platitelji")) {
                Cache::forever(Session::get('klijentId') . "Platitelji", Klijent::find(Session::get('klijentId'))->partneri()->with('ziroRacuni'));
            }*/
        }
        View::share(['ZiroRacuni' => Cache::get(Session::get('klijentId').'Platitelji')]);
        View::share(['Primatelji' => Cache::get('Primatelji')]);
        View::share(['SifreNamjene' =>  Cache::get("SifreNamjene")] );
        View::share(['Valute' =>  Cache::get("Valute")] );
        View::share(['ModeliPlacanja' =>  Cache::get("ModeliPlacanja")] );

        View::share('naslovTabele', 'Nalozi');
        View::share('naslovModala', 'Nalog za plaćanje');
        View::share('textDodajGumba', 'Dodaj Nalog');
        View::share('tabelaStupci', $tabelaStupci);
        View::share('tabelaStupci2', $tabelaStupci2);
        View::share('predlozak', false);
        View::share('selectedPredlosci', false);
        View::share('formName', 'predlozak');
        View::share('formPartneriName', 'partneri');

        View::share('rutaDohvatPartnera', '../../ziro/');
        View::share('RutaProvjeraIbana', '../../ProvjeraIbana/');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Klijent $klijent, ZbrojniNalog $zbrojniNalog, Request $request)
    {
        $vrstaNalogaF = $request->get('vrstaNaloga');
        return view('datatables.klijenti.zbrojniNalog.nalozi.index', compact('klijent','zbrojniNalog','vrstaNalogaF'));
    }

}
