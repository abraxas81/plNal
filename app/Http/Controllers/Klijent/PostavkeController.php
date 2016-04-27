<?php

namespace App\Http\Controllers\Klijent;

use App\Klijent;
use App\Parametar;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;
use App\Services\PorukeOperaterima;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PostavkeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store resources
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Klijent $klijent, Request $request)
    {
        try {
            $request->merge(['KlijentiId' => $klijent->id]);
            $racuniPlatitelja = Parametar::create($request->all());
            Log::info(Auth::user()->name. ' dodao je žiro račune za plačanje klijentu'. $klijent->Naziv);
        }catch (\Illuminate\Database\QueryException $e) {
            //dd($e->errorInfo[1]);
            Flash::error(PorukeOperaterima::sqlPoruka($e->errorInfo[1]));
        }
        Flash::success('Postavke su dodane');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  Klijent $klijent
     * @return \Illuminate\Http\Response
     */
    public function show(Klijent $klijent, Parametar $parametar)
    {
        return response()->json($parametar);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Klijent $klijent
     * @param  Parametar $parametar
     * @return \Illuminate\Http\Response
     */
    public function update(Klijent $klijent, Parametar $parametar, Request $request)
    {
        try {
            $request->merge(['KlijentiId' => $klijent->id]);
            $parametar->update($request->all());
            Log::info(Auth::user()->name. ' uredio je žiro račune za plačanje klijentu'. $klijent->Naziv);
        }catch (\Illuminate\Database\QueryException $e) {
            //dd($e->errorInfo[1]);
            Flash::error(PorukeOperaterima::sqlPoruka($e->errorInfo[1]));
        }
        Flash::success('Postavke računa plačanja su uređene');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
