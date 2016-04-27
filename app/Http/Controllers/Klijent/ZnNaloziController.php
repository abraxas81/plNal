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
use Illuminate\Support\Facades\Log;


class ZnNaloziController extends PredlozakNaloziController
{

    public function BasicData(Klijent $klijent, ZbrojniNalog $zbrojniNalog)
    {
        $nalozi = $zbrojniNalog->nalozi()->with('platitelj','primatelj','valute','modelOdobrenja','modelZaduzenja')->select(['*', 'Nalozi.id as nid']);;

        $datatables =  app('datatables')->of($nalozi)
            ->editColumn("platitelj.IBAN", function ($nalozi) {
                return '<a href="#" class="detalji" data-action="../../ziro/'.$nalozi->platitelj->id.'" data-title="Podaci o platitelju">'.$nalozi->platitelj->IBAN.'</a>';
            })
            ->editColumn("primatelj.IBAN", function ($nalozi) {
                return '<a href="#" class="detalji" data-action="../../ziro/'.$nalozi->primatelj->id.'" data-title="Podaci o primatelju">'.$nalozi->primatelj->IBAN.'</a>';
            })
            ->editColumn('Iznos', function($nalozi){
                return number_format($nalozi->Iznos, 2);
            })
            ->addColumn('action', function ($nalozi) {
                return '<a href="#" class="edit" title="Uredi" data-toggle="modal" data-platitelj="'.$nalozi->PlatiteljId.'" data-primatelj="'.$nalozi->ZiroPrimatelja.'" data-target="#Modal" data-action="nalozi/'.$nalozi->nid.'" data-action2="predlosci"><span class="glyphicon glyphicon-edit" ></i></a>
                        <a href="nalozi/'.$nalozi->nid.'" title="Obriši" data-method="delete" data-confirm="Jeste li sigurni?"><i class="glyphicon glyphicon-trash"></i></a>
                        ';
            });

        // vrsta Naloga filter
        if ($vrstaNalogaFilter = $datatables->request->get('vrstaNalogaFilter')) {
            $datatables->where('VrstaNalogaId',  $vrstaNalogaFilter);
        }

        // slovo search
        if ($alphabetSearch = $datatables->request->get('alphabetSearch')) {
            $datatables->where('Nalozi.Naziv', 'like', "$alphabetSearch%");
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
       $request->merge(['ZbrojniNalogId' => $zbrojniNalog->id]);
       $nalog = Nalog::create($request->all());
       $klijent->nalozi()->attach($nalog);
        Log::info(Auth::user()->name. ' dodao je nalog id='. $nalog->id.' u zbrojni nalog '.$zbrojniNalog->Naziv);
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
    public function show(Klijent $klijent, ZbrojniNalog $zbrojniNalog,Nalog $nalog)
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
    public function update(Klijent $klijent, ZbrojniNalog $zbrojniNalog, Nalog $nalog, Request $request)
    {
        $nalog->update($request->all());
        $klijent->nalozi()->attach($nalog);
        $request->merge(['ZbrojniNalogId' => $zbrojniNalog->id]);
        Log::info(Auth::user()->name. ' uredio je nalog id='. $nalog->id.' u zbrojnom nalogu '.$zbrojniNalog->Naziv.'{Ip adresa :'.request()->ip().'}');
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
    public function destroy(Klijent $klijent, ZbrojniNalog $zbrojniNalog, Nalog $nalog)
    {
        $klijent->nalozi()->detach($nalog);
        Log::info(Auth::user()->name. ' maknuo je nalog id='. $nalog->id.' iz zbrojnog Naloga '.$zbrojniNalog->Naziv);
        $nalog->destroy($nalog->id);
        Flash::success('Nalog je uspješno obrisan');
        return back();
    }
}
