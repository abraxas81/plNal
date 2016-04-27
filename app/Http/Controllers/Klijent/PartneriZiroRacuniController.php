<?php

namespace App\Http\Controllers\Klijent;

use App\Klijent;
use App\ZiroRacun;
use App\Partner;
use Illuminate\Http\Request;
use Datatables;
use App\Http\Requests;
use Illuminate\Support\Facades\View;
use Laracasts\Flash\Flash;
use App\Services\PorukeOperaterima;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PartneriZiroRacuniController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ajax',['only' => 'show']);
        //['key'] => ['displayTitle',position, 'visible','searchable', 'orderable']
        $tabelaStupci = [
            ['IBAN','IBAN','IBAN',0,true,true,true],
            ['vaziod','vaziod','Važi Od',1,true,true,true],
            ['vazido','vazido','Važi Do',2,true,true,true],
            ['action','action','Akcije',3,true,false,false]
        ];
        view()->share('description', $this->getDescription('ZiroRacuni'));
        view()->share('title', $this->getTitle('ZiroRacuni'));
        view()->share('naslovModala', 'Žiro račun');
        view()->share('formName', 'frmZiro');
        view()->share('textDodajGumba', 'Dodaj Račun');
        view()->share('naslovTabele', 'Žiro računi');
        view()->share('tabelaStupci', $tabelaStupci);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param Klijent $klijent
     * @param Partner $partner
     */
    public function index(Klijent $klijent,Partner $partner)
    {
        return View::make('datatables.klijenti.partneri.ziroRacuni.index', compact('klijent','partner'));
    }

    public function BasicData(Klijent $klijent,Partner $partner)
    {
        $ziroRacuni = ZiroRacun::where('PartneriId',$partner->id)->get();

            return Datatables::of($ziroRacuni)
                ->addColumn('action', function ($ziroRacuni) {
                    return '<a href="#" class="edit" title="Uredi" data-toggle="modal" data-target="#Modal" data-action="ziro/' . $ziroRacuni->id . '"><span class="glyphicon glyphicon-edit" ></i></a>
                            <a href="ziro/' . $ziroRacuni->id . '" data-method="delete" data-confirm="Jeste li sigurni?"><i class="glyphicon glyphicon-trash"></i></a>';
                })
                ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Klijent $klijent
     * @param Partner $partner
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Klijent $klijent,Partner $partner)
    {
        $request->merge(['PartneriId', $partner->id]);
        $ziroRacun = ZiroRacun::create($request->all());
        Log::info(Auth::user()->name. ' dodao je žiro račun'.$ziroRacun->IBAN);
        Flash::success('Žiro račun je dodan');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  Klijent $klijent
     * @param Partner $partner
     * @param ZiroRacun $ziroRacun
     * @return \Illuminate\Http\Response
     */
    public function show(Klijent $klijent,Partner $partner, ZiroRacun $ziroRacun)
    {
        return response()->json($ziroRacun);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Klijent $klijent
     * @param Partner $partner
     * @param ZiroRacun $ziroRacun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Klijent $klijent,Partner $partner, ZiroRacun $ziroRacun)
    {
        $request->merge(['PartneriId', $partner->id]);
        $ziroRacun->update($request->all());
        Log::info(Auth::user()->name. ' uredio je žiro račun'.$ziroRacun->IBAN);
        Flash::success('Ziro Racun je uređen');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Klijent $klijent
     * @param Partner $partner
     * @param ZiroRacun $ziroRacun
     * @return \Illuminate\Http\Response
     */
    public function destroy(Klijent $klijent,Partner $partner, ZiroRacun $ziroRacun)
    {
        $ziroRacun->delete();
        Log::info(Auth::user()->name. ' obrisao je žiro račun'.$ziroRacun->IBAN);
        Flash::success('Žiro račun je uspješno obrisan');

        return back();
    }
}
