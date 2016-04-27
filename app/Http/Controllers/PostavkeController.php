<?php

namespace App\Http\Controllers;

use App\Parametar;
use App\TipParametra;


class PostavkeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ajax',['only' => 'show']);
        //['key'] => ['displayTitle',position, 'visible','searchable', 'orderable']
        $tabelaStupci = [
            ['NazivParametra','NazivParametra','Naziv Parametra',0,true,true,true],
            ['OpisParametra','OpisParametra','Opis Parametra',1,true,false,false],
            ['Vrijednost','Vrijednost','Vrijednost',2,true,false,false],
            ['created_at','created_at','Kreirana',3,true,false,false],
            ['updated_at','updated_at','Ažurirana',4,true,false,false],
            ['action','Akcije','Akcije',5,true,false,false]
        ];
        
        if(!Cache::has("TipPostavke")) {
            $tipPostavke = TipParametra::all();
            Cache::forever("TipPostavke", $tipPostavke);
        }
        
        view()->share('description', $this->getDescription('Postavke'));

        View::share(['tipPostavke' =>  Cache::get("TipPostavke")] );
        View::share('naslovTabele', 'Postavke');
        View::share('naslovModala', 'Postavke');
        View::share('textDodajGumba', 'Dodaj Postavku');
        View::share('tabelaStupci', $tabelaStupci);
        View::share('formName', 'postavke');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('datatables.operateri.postavke.index');
    }

    public function BasicData()
    {
        $parametri = Parametar::all();

        return Datatables::of($parametri)
            ->addColumn('action', function ($parametri) {
                return '<a class="edit" data-toggle="modal" data-target="#Modal" data-action="postavke/'.$parametri->id.'"><span class="glyphicon glyphicon-edit" ></i></a>
                        <a href="postavke/'.$parametri->id.'" data-method="delete" data-confirm="Jeste li sigurni?"><i class="glyphicon glyphicon-trash"></i></a>                      
                        ';
            })
            ->make(true);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Parametar $parametar
     * @return \Illuminate\Http\Response
     */
    public function store(Parametar $parametar, Request $request)
    {
        try {
            Parametar::create($request->all());
            //$this->syncDozvole($role, $request->input('dozvole'));
        }catch (\Illuminate\Database\QueryException $e) {
            //dd($e->errorInfo[1]);
            Flash::error(PorukeOperaterima::sqlPoruka($e->errorInfo[1]));
            return back();
        }
        Flash::success('Parametar je dodan');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  Parametar $parametar
     * @return \Illuminate\Http\Response
     */
    public function show(Parametar $parametar)
    {
        //$role = $role->load('dozvole');
        return response()->json($parametar);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Parametar $parametar
     * @return \Illuminate\Http\Response
     */

    public function update(Parametar $parametar, Request $request)
    {
        try {
            $parametar->update($request->all());            
        } catch (\Illuminate\Database\QueryException $e) {
            //dd($e->errorInfo[1]);
            Flash::error(PorukeOperaterima::sqlPoruka($e->errorInfo[1]));
            return back();
        }
        Flash::success('Parametar je uređen');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Parametar $parametar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parametar $parametar)
    {
        try {
            $parametar->destroy($parametar->id);           
        } catch (\Illuminate\Database\QueryException $e) {
            //dd($e->errorInfo[1]);
            Flash::error(PorukeOperaterima::sqlPoruka($e->errorInfo[1]));
            return back();
        }
        Flash::success('Parametar je uspješno obrisan');
        return back();
    }
}
