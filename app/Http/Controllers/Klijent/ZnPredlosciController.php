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
use Illuminate\Support\Facades\Log;

class ZnPredlosciController extends PredlozakNaloziController
{

    public function BasicData(Klijent $klijent, ZbrojniNalog $zbrojniNalog)
    {
        $predlosci = $klijent->predlosci()->with('platitelj','primatelj','valute','modelOdobrenja','modelZaduzenja')->select(['*', 'Predlosci.id as prid']);

        $datatables =  app('datatables')->of($predlosci)
            ->editColumn("platitelj.IBAN", function ($predlosci) {
                return '<a href="#" class="detalji" data-action="../../ziro/'.$predlosci->platitelj->id.'" data-title="Podaci o platitelju">'.$predlosci->platitelj->IBAN.'</a>';
            })
            ->editColumn("primatelj.IBAN", function ($predlosci) {
                return '<a href="#" class="detalji" data-action="../../ziro/'.$predlosci->primatelj->id.'" data-title="Podaci o primatelju">'.$predlosci->primatelj->IBAN.'</a>';
            })
            ->editColumn("Iznos", function($nalozi){
                return number_format($nalozi->Iznos, 2);
            })
            ->addColumn('action', function ($predlosci) {
                return '<a href="#" class="edit" title="Uredi" data-toggle="modal" data-platitelj="'.$predlosci->PlatiteljId.'" data-primatelj="'.$predlosci->ZiroPrimatelja.'" data-target="#Modal" data-action="predlosci/'.$predlosci->prid.'" data-action2="nalozi"><span class="glyphicon glyphicon-edit" ></i></a>
                        <a href="../../predlosci/'.$predlosci->prid.'" title="Obriši" data-method="delete" data-confirm="Jeste li sigurni?"><i class="glyphicon glyphicon-trash"></i></a>                
                        ';
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Klijent $klijent, ZbrojniNalog $zbrojniNalog, Request $request)
    {
        $request->merge(['KlijentiId' => $klijent->id]);
        $predlozak = Predlozak::create($request->all());
        Log::info(Auth::user()->name. ' dodao je predložak '. $predlozak->Naziv);
        Flash::success('Predložak je dodan');
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  Klijent $klijent
     * @param  Predlozak $predlozak
     * @return \Illuminate\Http\Response
     */
    public function show(Klijent $klijent, ZbrojniNalog $zbrojniNalog, Predlozak $predlozak, Request $request)
    {
         return response()->json($predlozak->load(['primatelj','primatelj.partneri']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Klijent $klijent
     * @param  ZbrojniNalog $zbrojniNalog
     * @param  Predlozak $predlozak
     * @return \Illuminate\Http\Response
     */
    public function update(Klijent $klijent, ZbrojniNalog $zbrojniNalog, Predlozak $predlozak, Request $request)
    {
        $request->merge(['KlijentiId' => $klijent->id]);
        $predlozak->update($request->all());
        Log::info(Auth::user()->name. ' uredio je predložak '. $predlozak->Naziv);
        Flash::success('Predložak je uređen');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Klijent $klijent
     * @param  ZbrojniNalog $zbrojniNalog
     * @param  Predlozak $predlozak
     * @return \Illuminate\Http\Response
     */
    public function destroy(Klijent $klijent, ZbrojniNalog $zbrojniNalog, Predlozak $predlozak)
    {
        try {
            $predlozak->destroy($predlozak->id);
        } catch (\Illuminate\Database\QueryException $e) {
            //dd($e->errorInfo[1]);
            Flash::error(PorukeOperaterima::sqlPoruka($e->errorInfo[1]));
            return back();
        }
        Log::info(Auth::user()->name. ' obrisao je predložak '. $predlozak->Naziv);
        Flash::success('Predložak je uspješno obrisan');
        return back();
    }
}
