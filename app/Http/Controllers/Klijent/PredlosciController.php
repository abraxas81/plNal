<?php

namespace App\Http\Controllers\Klijent;

use App\Klijent;
use App\Predlozak;
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


class PredlosciController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('ajax',['only' => 'show']);
        //['key'] => ['name','data',position, 'visible','searchable', 'orderable']
        //ovo su defaultne postavke
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
        view()->share('title', $this->getTitle('Predlosci'));

        //definiram koja se postavka koristi ovdje
        $tipPostavke =  Cache::get('TipPostavkeRacuni');
        //provjeravam da li klijent već ima neke postavke
        $parametriPlatitelj = Parametar::where('KlijentiId',Session::get('klijentId'))->where('TipParametraId',$tipPostavke->id)->first();
        //ako si je odabrao s kojih će računa plaćati odabire se smanjeni broj računa u selectu
        if($parametriPlatitelj){
            Cache::forever(Session::get('klijentId') . "Platitelji", ZiroRacun::whereIn('id',$parametriPlatitelj->Vrijednost)->with('partneri')->get());
        //inače se odabiru svi platitelji kojima je pridružen
        }else{
            ZiroRacun::with(['partneri','partneri.klijenti' => function($q){$q->where('Klijenti_id',Session::get('klijentId'));}])->get();
            /*if (!Cache::has(Session::get('klijentId')."Platitelji")) {
                Cache::forever(Session::get('klijentId') . "Platitelji", Klijent::find(Session::get('klijentId'))->partneri()->with('ziroRacuni'));
            }*/
        }
        /*if(!Cache::get(Session::get('klijentId').'Platitelji')){
            View::share(['ZiroRacuni' => Cache::get(Session::get('klijentId').'Platitelji')]);
        }else{
            Flash::success('Molimo odaberite račune za plaćanje');
            return redirect('klijenti');
        }*/

        View::share(['ZiroRacuni' => Cache::get(Session::get('klijentId').'Platitelji')]);
        View::share(['Primatelji' => Cache::get('Primatelji')]);
        View::share(['SifreNamjene' =>  Cache::get("SifreNamjene")] );
        View::share(['Valute' =>  Cache::get("Valute")] );
        View::share(['ModeliPlacanja' =>  Cache::get("ModeliPlacanja")] );

        View::share('naslovTabele', 'Predlošci');
        View::share('naslovModala', 'Predložak naloga za nacionalno plaćanje u kunama');
        View::share('textDodajGumba', 'Dodaj Predložak');
        View::share('tabelaStupci2', $tabelaStupci2);
        View::share('predlozak', true);
        View::share('selectedPredlosci', true);
        View::share('formName', 'frmPredlozak');
        View::share('formPartneriName', 'frmPartneri');
        View::share('rutaDohvatPartnera', 'ziro/');
        View::share('RutaProvjeraIbana', 'ProvjeraIbana/');

    }
    /**
     * Display a listing of the resource.
     *
     * @param  Klijent $klijent     *
     * @return \Illuminate\Http\Response

     */
    public function index(Klijent $klijent, Request $request)
    {
        $vrstaNalogaF = $request->get('vrstaNaloga');
        return view('datatables.klijenti.predlosci.index', compact('klijent','vrstaNalogaF'));
    }

    /**
     * Dohvacanje podataka preko ajaxa.
     *
     * @param  Klijent $klijent     *
     * @return \Illuminate\Http\Response

     */
    public function BasicData(Klijent $klijent)
    {
        $predlosci = $klijent->predlosci()->with('platitelj','primatelj','valute','modelOdobrenja','modelZaduzenja')->select(['*', 'Predlosci.id as prid']);

        $datatables =  app('datatables')->of($predlosci)
            ->editColumn("platitelj.IBAN", function ($predlosci) {
                return '<a href="#" class="detalji" data-action="ziro/'.$predlosci->platitelj->id.'" data-title="Podaci o platitelju">'.$predlosci->platitelj->IBAN.'</a>';
                })
            ->editColumn("primatelj.IBAN", function ($predlosci) {
                return '<a href="#" class="detalji" data-action="ziro/'.$predlosci->primatelj->id.'" data-title="Podaci o primatelju">'.$predlosci->primatelj->IBAN.'</a>';
            })
            ->setRowId('prid')
            ->editColumn("Iznos", function($nalozi){
                return number_format($nalozi->Iznos, 2);
            })
            ->editColumn("Naziv", function ($predlosci) {
                return '<a href="#" class="edit" title="Uredi" data-toggle="modal" data-target="#Modal" data-action="predlosci/'.$predlosci->prid.'">'.$predlosci->Naziv.'</a>';
            })
            ->editColumn('action', function ($predlosci) {
              $result="";
                //if(Auth::user()->can(['edit'])){
                    $result.= '<a href="#" class="edit" title="Uredi" data-toggle="modal" data-platitelj="'.$predlosci->PlatiteljId.'" data-primatelj="'.$predlosci->ZiroPrimatelja.'" data-target="#Modal" data-action="predlosci/'.$predlosci->prid.'" data-action2="nalozi/"><span class="glyphicon glyphicon-edit" ></i></a>';
                //};
                if(Auth::user()->can(['delete'])) {
                    $result .= '<a href="predlosci/' . $predlosci->prid . '" title="Obriši" data-method="delete" data-confirm="Jeste li sigurni?"><i class="glyphicon glyphicon-trash"></i></a>';
                };
                return $result;
            });

        // vrsta Predloška filter
        if ($vrstaNalogaFilter = $datatables->request->get('vrstaNalogaFilter')) {
            $datatables->where('VrstaNalogaId',  $vrstaNalogaFilter);
        }

        // slovo search
        if ($alphabetSearch = $datatables->request->get('alphabetSearch')) {
            $datatables->where('Predlosci.Naziv', 'like', "$alphabetSearch%");
        }

        return $datatables->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Klijent $klijent
     * @param  ZbrojniNalog $zbrojniNalog
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Klijent $klijent,ZbrojniNalog $zbrojniNalog, Request $request)
    {
        $request->merge(['KlijentiId' => $klijent->id]);
        Predlozak::create($request->all());

        Flash::success('Predložak je dodan');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  Predlozak $predlozak
     * @return \Illuminate\Http\Response
     */
    public function show(Klijent $klijent, Predlozak $predlozak)
    {
        return response()->json($predlozak->load(['primatelj','primatelj.partneri']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Klijent $klijent
     * @param  Predlozak $predlozak
     * @return \Illuminate\Http\Response
     */
    public function update(Klijent $klijent, Predlozak $predlozak, Request $request)
    {
        $request->merge(['KlijentiId' => $klijent->id]);
        $predlozak->update($request->all());

        Flash::success('Predložak je uređen');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Klijent $klijent
     * @param  Predlozak $predlozak
     * @return \Illuminate\Http\Response
     * pošto je veza many to many malo to provjeriti
     */
    public function destroy(Klijent $klijent, Predlozak $predlozak)
    {
        $predlozak->destroy($predlozak->id);

        Flash::success('Predložak je uspješno obrisan');
        return back();
    }
}
