<?php namespace App\Http\Controllers\Klijent;

use App\Klijent;
use App\VrstaNaloga;
use App\ZbrojniNalog;
use Datatables;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use App\Services\PorukeOperaterima;

class VrsteNalogaController extends Controller
{
    public function __construct()
    {
        view()->share('description', $this->getDescription('VrsteNaloga'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Klijent $klijent
     * @param  VrstaNaloga $vrstaNaloga
     * @return \Illuminate\Http\Response

     */
    public function index(Klijent $klijent)
    {
        return view('datatables.klijenti.vrsteNaloga.index', compact('klijent'));
    }

    public function BasicData($klijentId)
    {
        $zbrojniNalozi = ZbrojniNalog::ZNKlijenta($klijentId)->get();

        return Datatables::of($zbrojniNalozi)
                            ->addColumn('action', function ($zbrojniNalozi) {
                                return '<a href="#edit-'.$zbrojniNalozi->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                                        <a href="prikazi-Naloge/'.$zbrojniNalozi->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Remove</a>
                                        ';
                            })
                            ->make(true);
    }

}
