<?php

namespace App\Http\Controllers\Klijent;

use App\Klijent;
use App\Nalog;
//
use App\Parametar;
use App\ZbrojniNalog;
use App\ZiroRacun;

use app\Services\moneyFormatter;
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
use Illuminate\Support\Facades\Log;

class NaloziController extends Controller
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
       
        view()->share('description', $this->getDescription('Predlosci'));
        view()->share('title', $this->getTitle('Predlosci'));

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
        View::share('predlozak', false);
        View::share('formPartneriName', 'partneri');
        View::share('formName', 'nalozi');
        View::share('rutaDohvatPartnera', 'ziro/');
        View::share('RutaProvjeraIbana', 'ProvjeraIbana/');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Klijent $klijent, Request $request)
    {
        $vrstaNalogaF = $request->get('vrstaNaloga');
        return view('datatables.klijenti.nalozi.index', compact('klijent','vrstaNalogaF'));
    }

    public function BasicData(Klijent $klijent)
    {
        $nalozi = $klijent->nalozi()->with('platitelj','primatelj','valute','modelOdobrenja','modelZaduzenja')->select(['*', 'Nalozi.id as naid']);

        $datatables =  app('datatables')->of($nalozi)
            ->editColumn("platitelj.IBAN", function ($nalozi) {
                return '<a href="#" class="detalji" data-action="ziro/'.$nalozi->platitelj->id.'" data-title="Podaci o platitelju">'.$nalozi->platitelj->IBAN.'</a>';
            })
            ->editColumn("primatelj.IBAN", function ($nalozi) {
                return '<a href="#" class="detalji" data-action="ziro/'.$nalozi->primatelj->id.'" data-title="Podaci o primatelju">'.$nalozi->primatelj->IBAN.'</a>';
            })
            ->editColumn('Iznos', function($nalozi){
                return number_format($nalozi->Iznos, 2);
            })
            ->addColumn('action', function ($nalozi) {
                return '<a href="#" class="edit" title="Uredi" data-toggle="modal" data-platitelj="'.$nalozi->PlatiteljId.'" data-primatelj="'.$nalozi->ZiroPrimatelja.'" data-target="#Modal" data-action="nalozi/'.$nalozi->naid.'" data-action2="predlosci"><span class="glyphicon glyphicon-edit" ></i></a>
                        <a href="nalozi/'.$nalozi->naid.'" title="Obriši" data-method="delete" data-confirm="Jeste li sigurni?"><i class="glyphicon glyphicon-trash"></i></a>
                        ';
            });

        // vrsta Naloga filter
        if ($vrstaNalogaFilter = $datatables->request->get('vrstaNalogaFilter')) {
            $datatables->where('VrstaNalogaId',  $vrstaNalogaFilter);
        }

        return $datatables->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Klijent $klijent, Request $request)
    {
       $nalog = Nalog::create($request->all());
       Log::info(Auth::user()->name. ' dodao je nalog '.$nalog->id);
       $klijent->nalozi()->attach($nalog);

        Flash::success('Nalog je kreiran');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  Klijent $klijent
     * @param  Nalog $nalog
     * @return \Illuminate\Http\Response
     */
    public function show(Klijent $klijent, Nalog $nalog, Request $request)
    {
            return response()->json($nalog->load(['primatelj','primatelj.partneri']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Klijent $klijent
     * @param  Nalog $nalog
     * @return \Illuminate\Http\Response
     */
    public function update(Klijent $klijent, Nalog $nalog, Request $request)
    {
       $nalog->update($request->all());
        Log::info(Auth::user()->name. ' uredio je nalog '.$nalog->id);
       $klijent->nalozi()->attach($nalog);

        Flash::success('Nalog je uređen');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Klijent $klijent
     * @param  Nalog $nalog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Klijent $klijent, Nalog $nalog)
    {
       $klijent->nalozi()->detach($nalog);
       $nalog->destroy($nalog->id);
        Log::info(Auth::user()->name. ' obrisao je nalog id'.$nalog->id);
        Flash::success('Nalog je uspješno obrisan');
        return back();
    }
}
