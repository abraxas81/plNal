<?php

namespace App\Http\Controllers\Klijent;

use App\Klijent;
use App\NacinIzvrsenja;
use App\Nalog;
use App\ZbrojniNalog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Datatables;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
Use Laracasts\Flash\Flash;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ZbrojniNalogController extends Controller
{
    public function __construct(){
        
        $this->middleware('auth');
        $this->middleware('ajax',['only' => 'show']);

        //['key'] => ['displayTitle',position, 'visible','searchable', 'orderable']
        $tabelaStupci = [
            ['Naziv','Naziv','Naziv Naloga',0,true,true,true],
            ['created_at','ZbrojniNalog.created_at','Stvoreno',1,true,false,false],
            ['updated_at','ZbrojniNalog.updated_at','Ažurirano',2,true,false,false],
            ['count','count','Broj naloga',3,true,false,false],
            ['iznos','iznos','Iznos',4,true,false,false],
            ['action','Akcije','Akcije',5,true,false,false]
        ];

        if (!Cache::has("NaciniIzvrsenja")) {
            $NaciniIzvrsenja = NacinIzvrsenja::all();
            Cache::forever("NaciniIzvrsenja", $NaciniIzvrsenja);
        }

        view()->share('description', $this->getDescription('Zbrojni nalozi'));
        view()->share('title', $this->getTitle('Zbrojni nalozi'));
        View::share('NaciniIzvrsenja', Cache::get('NaciniIzvrsenja'));
        View::share('naslovTabele', 'Zbrojni Nalozi');
        View::share('naslovModala', 'Zbrojni nalog');
        View::share('textDodajGumba', 'Dodaj Zbrojni Nalog');
        View::share('tabelaStupci', $tabelaStupci);
        View::share('formName', 'zbrojniNalozi');
    }
    /**
     * Display a listing of the resource.
     *
     * @param Klijent $klijent
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Klijent $klijent, Request $request)
    {
        $vrstaNalogaF = $request->get('vrstaNaloga');
        return view('datatables.klijenti.zbrojniNalog.index', compact('klijent', 'vrstaNalogaF'));
    }

    public function BasicData(Klijent $klijent)
    {
        $zbrojniNalozi  = $klijent->zbrojniNalozi()->with('nalozi');

        $datatables =  app('datatables')->of($zbrojniNalozi)
            ->editColumn('Naziv', function($zbrojniNalozi){
                return '<a href="zbrojniNalog/'.$zbrojniNalozi->id.'/nalozi?vrstaNaloga='.$zbrojniNalozi->VrstaNalogaId.'">'.$zbrojniNalozi->Naziv.'</a>';
            })
            ->addColumn('count', function($zbrojniNalozi){
                return $zbrojniNalozi->nalozi()->count();
            })
            ->editColumn('iznos', function($zbrojniNalozi){
                return number_format($zbrojniNalozi->nalozi()->sum('Iznos'), 2).' kn';
            })
            ->addColumn('action', function ($zbrojniNalozi) {
                return '<a href="#" class="edit" title="Uredi" data-toggle="modal" data-target="#Modal" data-action="zbrojniNalog/'.$zbrojniNalozi->id.'"> <span class="glyphicon glyphicon-edit" ></i></a>
                        <a href="zbrojniNalog/'.$zbrojniNalozi->id.'" title="Obriši" data-method="delete" data-confirm="Jeste li sigurni?"> <i class="glyphicon glyphicon-trash"></i></a>
                        <a href="zbrojniNalog/'.$zbrojniNalozi->id.'/datoteka" title="Datoteka zbrojnog naloga" data-action="zbrojniNalog/'.$zbrojniNalozi->id.'/datoteka"> <i class="glyphicon glyphicon-share"></i></a>
                        <a href="zbrojniNalog/'.$zbrojniNalozi->id.'/predložak" title="Iskoristi kao predložak"> <i class="glyphicon glyphicon-list-alt"></i></a>
                        <!--<a href="#" class="edit predlozak" title="Iskoristi kao predložak" data-toggle="modal" data-target="#Modal" data-action="zbrojniNalog/'.$zbrojniNalozi->id.'" data-action2="zbrojniNalog/'.$zbrojniNalozi->id.'/predložak"> <i class="glyphicon glyphicon-list-alt"></i></a>-->
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
    public function Predlozak(Klijent $klijent, ZbrojniNalog $zbrojniNalog, Nalog $nalozi){

        $nalozi = $nalozi->where('ZbrojniNalogId',$zbrojniNalog->id)->get();

        $replicated = $zbrojniNalog->replicate();
        $replicated->save();
        Log::info(Auth::user()->name. ' iskoristio je zbrojni nalog'. $zbrojniNalog->Naziv.' kao predložak');
        foreach ($nalozi as $nalog){
            $nalog->datumizvrsenja = Carbon::parse($nalog->datumizvrsenja)->addMonth();
            $nalog->ZbrojniNalogId = $replicated->id;
            $nalog->replicate()->save();
            $klijent->nalozi()->attach($nalog);
        }
        return back();
    }
    
    public function datoteka(Klijent $klijent, ZbrojniNalog $zbrojniNalog){

        Storage::makeDirectory('zbrojniNalozi'.DIRECTORY_SEPARATOR.$zbrojniNalog->id); //result is 1

        $filename = 'zbrojniNalozi'.DIRECTORY_SEPARATOR.$zbrojniNalog->id.DIRECTORY_SEPARATOR."UN".date('Ymd').".txt";
        $file = "UN".date('Ymd').".txt";

        $slog300 = date('Ymd') . $zbrojniNalog->VrstaNalogaId.str_pad(300, 991," ",STR_PAD_LEFT);

        Storage::disk('local')->put($filename, $slog300);

       // mb_internal_encoding("iso-8859-1");

        $glaveSloga = ZbrojniNalog::glavaSloga($zbrojniNalog->id);

        foreach ($glaveSloga as $glavaSloga) {

            if(date('Y-m-d', strtotime($glavaSloga->DatumIzvrsenja)) < date('Y-m-d')){
                Storage::disk('local')->delete($filename);
                Flash::error('Greška :Datum izvršenja jednog od naloga stariji je od današnjeg datuma');
                return back();
            }
            $slog301 =  //-m-mandatory -o-obligatory
                str_pad($glavaSloga->IBAN, 21) .//IBAN platitelja (m)
                str_pad($glavaSloga->Alfa, 3) .//Oznaka valute plaćanja (m)
                str_pad("", 21) . //Račun naknade (o)
                str_pad("", 3) .  //Oznaka valute naknade (o)
                str_pad($glavaSloga->brojNaloga, 5, '0', STR_PAD_LEFT) . //Ukupan broj naloga u sljedećoj grupi (slogovi 309) (m)
                str_pad(str_replace([",", ".", " kn"], [""], $glavaSloga->suma), 20, '0', STR_PAD_LEFT) . //Ukupan iznos naloga u sljedećoj grupi (slogovi 309)(m)
                str_pad(str_replace(["-"], [""], $glavaSloga->DatumIzvrsenja), 8) . //Datum izvršenja naloga (m)
                str_pad("", 916) . //Rezerva
                str_pad(301, 3)//Tip Sloga
                ; //kraj linije

            //$slog301 = mb_convert_encoding($slog301,'UTF-8' ,'ISO-8859-2');

            Storage::disk('local')->append($filename, $slog301);

            $nalozi = ZbrojniNalog::stavke($glavaSloga->VrstaNalogaId, $glavaSloga->id, $glavaSloga->IBAN, $glavaSloga->DatumIzvrsenja);

            foreach ($nalozi as $nalog) {

                $slog309 = str_pad($nalog->ibanPrimatelja, 34) . //IBAN ili račun primatelja (m)
                    str_pad($nalog->nazivPrimatelja, 70) . //Naziv primatelja (ime i prezime) (m - 2,3,4)
                    str_pad("", 35) . //Adresa primatelja (v-2)
                    str_pad("", 35) . //Sjedište primatelja (v-2)
                    str_pad("", 3) .  //Šifra zemlje primatelja (v-2)
                    str_pad("HR" . $nalog->modelOdobrenja, 4) . //Broj modela platitelja (m*)
                    str_pad($nalog->BrojOdobrenja, 22) . // Poziv na broj platitelja(m*)
                    str_pad("", 4) . //Šifra namjene (o)
                    ($nalog->modelOdobrenja == 99 ? str_pad($nalog->Opis.' - '.$glavaSloga->Naziv.' ,'.$glavaSloga->Adresa , 140): str_pad($nalog->Opis, 140)). //Opis plaćanja
                    str_pad(str_replace([",", ".", " kn"], [""], $nalog->Iznos), 15, '0', STR_PAD_LEFT) . //Iznos (m)
                    str_pad("HR" . $nalog->modelZaduzenja, 4) . //Broj modela primatelja (m*)
                    str_pad($nalog->BrojZaduzenja, 22) . //Poziv na broj primatelja (m*)
                    str_pad("", 11) . //BIC (SWIFT) adresa (v)
                    str_pad("", 70) . //Naziv banke primatelja  (v)
                    str_pad("", 35) . //Adresa banke primatelja  (v)
                    str_pad("", 35) . //Sjedište banke primatelja  (v)
                    str_pad("", 3) . //Šifra zemlje banke primatelja (v)
                    str_pad("", 1) . //Vrsta strane osobe (v)
                    str_pad("", 3) . //Valuta pokrića  (v)
                    str_pad("", 1) . //Troškovna opcija (v)
                    str_pad("", 1) . //Oznaka hitnosti  (v)
                    str_pad("", 3) . //Šifra vrste osobnog primanja (m*)
                    str_pad("", 446) . //Rezerva (v)
                    str_pad(309, 3) //Tip sloga
                    ;
               // $slog309 = mb_convert_encoding($slog309, 'UTF-8', 'ISO-8859-2');
                Storage::disk('local')->append($filename, $slog309);
            }
        }

        $slog399 = str_pad(399, 1000," ",STR_PAD_LEFT);

        Storage::disk('local')->append($filename, $slog399);

        $path  = storage_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.$filename;
        Log::info(Auth::user()->name. ' generirao je datoteku zbrojnog naloga '. $filename);
        return response()->download($path, $file, ['Content-Type' => 'application/octet-stream']);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Klijent $klijent
     * @return \Illuminate\Http\Response
     */
    public function store(Klijent $klijent, Request $request)
    {
       $request->merge(['KlijentiId' => $klijent->id]);
       $zbrojniNalog = ZbrojniNalog::create($request->all());
        Log::info(Auth::user()->name. ' dodao je zbrojni nalog '. $zbrojniNalog->Naziv);
        Flash::success('Zbrojni nalog je dodan');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  Klijent $klijent
     * @return \Illuminate\Http\Response
     */
    public function show(Klijent $klijent, ZbrojniNalog $zbrojniNalog, Request $request)
    {
        return response()->json($zbrojniNalog);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Klijent $klijent
     * @param ZbrojniNalog $zbrojniNalog
     * @return \Illuminate\Http\Response
     */
    public function update(Klijent $klijent, ZbrojniNalog $zbrojniNalog, Request $request)
    {
        $request->merge(['KlijentiId' => $klijent->id]);
        $zbrojniNalog->update($request->all());
        Log::info(Auth::user()->name. ' uredio je zbrojni nalog '. $zbrojniNalog->Naziv);
        Flash::success('Zbrojni nalog je uređen');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Klijent $klijent
     * @param  ZbrojniNalog $zbrojniNalog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Klijent $klijent, ZbrojniNalog $zbrojniNalog)
    {
        $zbrojniNalog->destroy($zbrojniNalog->id);
        Log::info(Auth::user()->name. ' obrisao je zbrojni nalog '. $zbrojniNalog->Naziv);
        Flash::success('ZbrojniNalog je uspješno obrisan');
        return back();
    }
}
