<?php

namespace App\Http\Controllers\Klijent;

use App\Events\Event;
use App\Events\KlijentOdabran;
use App\Klijent;
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


class KlijentiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ajax',['only' => 'show']);
        
        $tabelaStupci = [
            ['Naziv','Naziv','Naziv Klijenta',0,true,true,true],
            ['created_at','created_at','Napravljen',1,true,true,true],
            ['updated_at','updated_at','Promjenjen',2,true,true,true],
            ['action','Akcije','Akcije',3,true,false,false]
        ];

        if(Auth::user()){
            $this->klijenti = Auth::user()->klijenti()->get();
        }
        view()->share('description', $this->getDescription('Klijenti'));
        view()->share('title', $this->getTitle('Klijenti'));
        view()->share('naslovModala', 'Klijent');
        view()->share('textDodajGumba', 'Dodaj Klijenta');
        view()->share('formName', 'klijent');
        view()->share('naslovTabele', 'Klijenti');
        view()->share('tabelaStupci', $tabelaStupci);
       
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //dd(Session::get('klijentId'));
        if($this->klijenti->count() == 1  &&!$request->has('manual')) {
            Session::put('klijentId', $this->klijenti->first()->id);
            Flash::success('Klijent je odabran automatski');
            return redirect('klijenti/'.$this->klijenti->first()->id.'/partneri');
        } else {
            $klijent = $this->klijenti->first();
            return view('datatables.klijenti.index', compact('klijenti','klijent'));
        }
    }

    public function BasicData()
    {
        $klijenti = $this->klijenti;

        $datatables =  app('datatables')->of($klijenti)
                ->editColumn('Naziv', function ($klijenti) {
                    return '<a href="klijenti/'.$klijenti->id.'/partneri">'.$klijenti->Naziv.'</a>';
                })
                ->addColumn('action', function ($klijenti) {
                    return '<a href="#" class="edit" title="Uredi" data-toggle="modal" data-target="#Modal" data-action="klijenti/'.$klijenti->id.'"><span class="glyphicon glyphicon-edit" ></i></a>
                            <a href="klijenti/'.$klijenti->id.'" data-method="delete" data-confirm="Jeste li sigurni?"><i class="glyphicon glyphicon-trash"></i></a>
                            <a href="klijenti/odaberi/'.$klijenti->id.'"><i class="glyphicon glyphicon-hand-down"></i></a>';
                });

        return $datatables->make(true);

    }

    /**
     * Odabir klijenta s kojim će se raditi
     *
     * @param  Klijent $klijenti
     */

    public function OdaberiKlijenta(Klijent $klijenti)
    {
        \Event::fire(new KlijentOdabran($klijenti));
        Log::info(Auth::user()->name. ' odabrao je klijenta '. $klijenti->Naziv);
        return redirect('klijenti/'.$klijenti->id.'/partneri');
    }

    public function ProvjeraIbana(Request $request){

        $result = ZiroRacun::where('IBAN','like',$request->get('iban'))->with('partneri')->get();
        return response()->json($result);
    }
    public function DohvatiPartnera(Klijent $klijent, ZiroRacun $ziroRacun, Request $request){

        if($request->has('tabela')){
            $partner = $ziroRacun->partneri()->first();

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
        return response()->json($ziroRacun->load('partneri'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $klijent = Klijent::create($request->all());
        Auth::user()->klijenti()->attach($klijent->id);
        Log::info(Auth::user()->name. ' dodao je klijenta '. $klijent->Naziv);
        Flash::success('Klijent je dodan');
        return back();
    }


    /**
     * Display the specified resource.
     *
     * @param  Klijent $klijent
     * @return \Illuminate\Http\Response
     */
    public function show(Klijent $klijent, Request $request)
    {
        return response()->json($klijent);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Klijent $klijent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Klijent $klijent)
    {
        $klijent->fill($request->all())->save();
        Log::info(Auth::user()->name. ' uredio je klijenta '. $klijent->Naziv);
        Flash::success('Klijent je uređen');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Klijent $klijent
     * @return \Illuminate\Http\Response
     * pošto je veza many to many malo to provjeriti
     */
    public function destroy(Klijent $klijent)
    {
        Auth::user()->klijenti()->detach($klijent->id);
        Log::info(Auth::user()->name. ' obrisao je klijenta '. $klijent->Naziv);
        Flash::success('Klijent je uspješno obrisan');
        return back();
    }
}
