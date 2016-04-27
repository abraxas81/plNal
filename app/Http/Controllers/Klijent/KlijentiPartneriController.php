<?php

namespace App\Http\Controllers\Klijent;

use App\Klijent;
use App\Parametar;
use App\Partner;
use App\TipParametra;
use App\ZiroRacun;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\Cache;
use Laracasts\Flash\Flash;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\PorukeOperaterima;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class KlijentiPartneriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ajax',['only' => 'show']);
        
        $tabelaStupci = [
            ['Naziv','Naziv','Naziv Klijenta',0,true,true,true],
            ['Adresa','Adresa','Adresa',1,true,true,true],
            ['Email','Email','Email',2,true,true,true],
            ['Telefon','Telefon','Telefon',3,true,true,true],
            ['Mobitel','Mobitel','Mobitel',4,true,true,true],
            ['OIB','OIB','OIB',5,true,true,true],
            ['action','action','Akcije',6,true,false,false]
        ];
        
        //definiram koja se postavka koristi ovdje
        $this->tipPostavke =  Cache::get('TipPostavkeRacuni');
        //provjeravam da li klijent već ima neke postavke


        view()->share('Tip', $this->tipPostavke->id);
        view()->share('description', $this->getDescription('Partneri'));
        view()->share('title', $this->getDescription('Partneri'));
        view()->share('naslovModala', 'Partner');
        view()->share('formPartneriName', 'frmPartneri');
        view()->share('formName', 'frmPartneri');
        view()->share('description', $this->getDescription('Klijenti'));
        view()->share('textDodajGumba', 'Dodaj Partnera');
        view()->share('naslovTabele', 'Klijenti');
        view()->share('tabelaStupci', $tabelaStupci);
    }

    /**
     * Display a listing of the resource.
     * @param Klijent $klijent
     * @return \Illuminate\Http\Response
     */
    public function index(Klijent $klijent)
    {
        $parametriPlatitelj = Parametar::where('KlijentiId',$klijent->id)->where('TipParametraId',$this->tipPostavke->id)->first();
        //ako si je odabrao s kojih će računa plaćati odabire se smanjeni broj računa u selectu

        if($parametriPlatitelj){
            Cache::forever($klijent->id . "Platitelji", ZiroRacun::whereIn('id',$parametriPlatitelj->Vrijednost)->with('partneri')->get());
        }else{
            ZiroRacun::with(['partneri','partneri.klijenti' => function($q){$q->where('Klijenti_id',Session::get('klijentId'));}])->get();
            /*if (!Cache::has(Session::get('klijentId')."Platitelji")) {
                Cache::forever(Session::get('klijentId') . "Platitelji", Klijent::find(Session::get('klijentId'))->partneri()->with('ziroRacuni'));
            }*/
        }

        view()->share('TipPostavke', $parametriPlatitelj);

        return view('datatables.klijenti.partneri.index', compact('klijent'));
    }

    public function BasicData(Klijent $klijent, Request $request)
    {
        $partneri = $klijent->partneri()->get();

        return Datatables::of($partneri)
            //->editColumn('title','{!! str_limit($title, 60) !!}')
            ->editColumn('Naziv', function ($partneri) {
                return '<a href="partneri/' . $partneri->id . '/ziro">' . $partneri->Naziv . '</a>';
            })
            ->addColumn('action', function ($partneri) {
                return '<a href="#" class="edit" title="Uredi" data-toggle="modal" data-target="#Modal" data-action="partneri/' . $partneri->id . '"><span class="glyphicon glyphicon-edit" ></i></a>                       
                        <a href="partneri/' . $partneri->id . '" data-method="delete" data-confirm="Jeste li sigurni?"><i class="glyphicon glyphicon-trash"></i></a>
                       ';})
            ->make(true);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Klijent $klijent
     * @return \Illuminate\Http\Response
     */
    public function store(Klijent $klijent, Request $request, ZiroRacun $ziroRacun)
    {
        try {
            $partner = Partner::create($request->all());
            Log::info(Auth::user()->name. ' dodao je partnera '. $partner->Naziv);
            $this->syncPartneri($partner, [$klijent->id], $klijent->Naziv);
            $request->merge(['PartneriId' => $partner->id]);

            if($request->ajax()){

                if($request->input('ziroId')){
                    $ziroRacun = ZiroRacun::find($request->input('ziroId'));
                    $ziroRacun->update($request->all());
                    Log::info(Auth::user()->name. ' uredio je žiro račun '. $ziroRacun->IBAN);
                } else {
                    $ziroRacun = ZiroRacun::create($request->all());
                    Log::info(Auth::user()->name. ' napravio je žiro račun '. $ziroRacun->IBAN);
                }
            }

        }catch (\Illuminate\Database\QueryException $e) {

            if($request->ajax()){
                $response = [
                    'message' => PorukeOperaterima::sqlPoruka($e->errorInfo[1]),
                    'id' => 0
                ];
                return response()->json($response);
            }else{
                //dd($e->errorInfo[1]);
                Flash::error(PorukeOperaterima::sqlPoruka($e->errorInfo[1]));
            }
        }

        if($request->ajax()){
            $response = [
                'message' =>'Partner je dodan',
                'id' => $ziroRacun->id
            ];
            return response()->json($response);
        }
        Flash::success('Partner je dodan');
        return back();
    }

    private function updateZiro(Request $request){
        if($request->ajax()){

            if($request->input('ziroId')){
                $ziroRacun = ZiroRacun::create($request->all());
            } else {
                $ziroRacun = ZiroRacun::find($request->input('ziroId')->update($request->all()));
            }
        }
        return $ziroRacun;
    }

    private function syncPartneri(Partner $partner, array $klijenti, $NazivKlijenta){
        $partner->klijenti()->sync($klijenti, false);
        Log::info(Auth::user()->name.' pridružio je '.$NazivKlijenta. ' partneru '. $partner->Naziv);
    }

    /**
     * Display the specified resource.
     *
     * @param  Klijent $klijent
     * @return \Illuminate\Http\Response
     */
    public function DohvatiPartnera(Klijent $klijent, Request $request){
        $partner = Partner::where('OIB','like',$request->get('oib'))->get();

        return response()->json($partner);
    }

    /**
     * Display the specified resource.
     *
     * @param  Klijent $klijent
     * @param  Partner $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Klijent $klijent, Partner $partner, Request $request)
    {
            $responseType = 0;
            if($responseType){
                $tabela = "<table>
                        <tr><td>Naziv :</td><td>$partner->Naziv</td></tr>
                        <tr><td>Adresa :</td><td>$partner->Adresa</td></tr>
                        <tr><td>Email :</td><td>$partner->Email</td></tr>
                        <tr><td>Telefon :</td><td>$partner->Telefon</td></tr>
                        <tr><td>Mobitel :</td><td>$partner->Mobitel</td></tr>
                        <tr><td>OIB :</td><td>$partner->OIB</td></tr>
                   </table>";
                return $tabela;
            } else {
                return response()->json($partner->load('ziroRacuni'));
            }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Klijent $klijent
     * @param  Partner $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Klijent $klijent, Partner $partner, ZiroRacun $ziroRacun)
    {
        //if($request->has('Promjene')){
            try {
                $partner->update($request->all());
                Log::info(Auth::user()->name. ' uredio je partnera '. $partner->Naziv);
                $this->syncPartneri($partner, [$klijent->id], $klijent->Naziv);
                //$partner->klijenti()->attach($klijent->id);
                $request->merge(['PartneriId' => $partner->id]);

                if($request->ajax()){

                    if($request->input('ziroId')){
                        $ziroRacun = ZiroRacun::find($request->input('ziroId'));
                        $ziroRacun->update($request->all());
                        Log::info(Auth::user()->name. ' uredio je žiro račun '. $ziroRacun->IBAN);
                    } else {
                        $ziroRacun = ZiroRacun::create($request->all());
                        Log::info(Auth::user()->name. ' dodao je žiro račun '. $ziroRacun->IBAN);
                    }
                }

            } catch (\Illuminate\Database\QueryException $e) {

                if($request->ajax()){
                    $response = [
                        'message' => PorukeOperaterima::sqlPoruka($e->errorInfo[1]),
                        'id' => 0
                    ];
                    return response()->json($response);
                }else{
                    //dd($e->errorInfo[1]);
                    Flash::error(PorukeOperaterima::sqlPoruka($e->errorInfo[1]));
                }
            }
            if($request->ajax()){
                $response = [
                    'message' =>'Partner je uređen',
                    'id' => $ziroRacun->id
                ];
                return response()->json($response);
            }
            Flash::success('Partner je uređen');
        //}
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Klijent $klijent
     * @param  Partner $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Klijent $klijent, Partner $partner)
    {
            $partner->klijenti()->detach($klijent->id);
            //$this->syncPartneri($partner, [$klijent->id]);

        Flash::success('Partner je uspješno uklonjen iz ove grupe');
        return back();
    }
}
