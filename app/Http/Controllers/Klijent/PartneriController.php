<?php

namespace App\Http\Controllers\Klijent;

use App\Klijent;
use Illuminate\Http\Request;
use Datatables;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use App\Services\PorukeOperaterima;

class KlijentiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
        view()->share('controller', 'Partneri');
        view()->share('title', $this->getTitle('Partneri'));
        view()->share('description', $this->getDescription('Partner'));
        view()->share('naslovModala', 'Partner');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        view()->share('name', 'Victoria');
        return view('datatables.partneri.index');
    }

    public function BasicData()
    {
        $partneri = Auth::user()->klijenti()->with('partneri', 'partneri.ziroRacuni')->get();

        return Datatables::of($partneri)
            //->editColumn('title','{!! str_limit($title, 60) !!}')
            ->editColumn('Naziv', function ($partneri) {
                return '<a href="partneri/'.$partneri->id.'">'.$partneri->Naziv.'</a>';
            })
            ->addColumn('action', function ($partneri) {
                return '<a class="btn btn-xs btn-primary edit" data-toggle="modal" data-target="#Modal" data-action="partneri/'.$partneri->id.'"><i class="glyphicon glyphicon-edit"></i> Uredi</a>
                        <a href="partneri/'.$partneri->id.'" class="btn btn-xs btn-danger" data-method="delete" data-confirm="Jeste li sigurni?"><i class="glyphicon glyphicon-remove"></i> Obriši</a>';
            })
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $klijent = Klijent::create($request->all());
            Auth::user()->klijenti()->attach($klijent->id);
        }catch (\Illuminate\Database\QueryException $e) {
            //dd($e->errorInfo[1]);
            Flash::error(PorukeOperaterima::sqlPoruka($e->errorInfo[1]));
            return redirect('klijenti');
        }
        Flash::success('Klijent je dodan');
        return redirect('klijenti');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $klijent = Klijent::find($id);
        return response()->json($klijent);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $klijent = Klijent::find($id);

        try {
            $klijent->fill($request->all())->save();
        } catch (\Illuminate\Database\QueryException $e) {
            dd($e->errorInfo[1]);
            Flash::error(PorukeOperaterima::sqlPoruka($e->errorInfo[1]));
            return redirect('klijenti');
        }
        Flash::success('Klijent je uređen');
        return redirect('klijenti');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * pošto je veza many to many malo to provjeriti
     */
    public function destroy($id)
    {
        try {
            Auth::user()->klijenti()->detach($id);
            //Klijent::find($id)->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            //dd($e->errorInfo[1]);
            Flash::error(PorukeOperaterima::sqlPoruka($e->errorInfo[1]));
            return redirect('klijenti');
        }
        Flash::success('Klijent je uspješno obrisan');
        return redirect('klijenti');
    }
}
