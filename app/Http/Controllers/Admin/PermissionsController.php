<?php

namespace App\Http\Controllers\Admin;

use App\Permission;

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

class PermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('ajax',['only' => 'show']);
        $this->middleware('permission.canEdit',['only' => 'show']);
        //['key'] => ['displayTitle',position, 'visible','searchable', 'orderable']
        $tabelaStupci = [
            ['name','permissions.name','Naziv Dozvole',0,true,true,true],
            ['display_name','permissions.display_name','Duži naziv',1,true,true,true],
            ['description','permissions.description','Naziv Operatera',2,true,true,true],
            ['created_at','permissions.created_at','Kreirana',3,true,false,false],
            ['updated_at','permissions.updated_at','Ažurirana',4,true,false,false],
            ['action','Akcije','Akcije',5,true,false,false]
        ];
        view()->share('description', $this->getDescription('Dozvole'));

        view()->share('naslovTabele', 'Dozvole');
        view()->share('naslovModala', 'Dozvola');
        view()->share('textDodajGumba', 'Dodaj Dozvolu');
        view()->share('tabelaStupci', $tabelaStupci);
        view()->share('formName', 'dozvole');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('datatables.admin.dozvole.index');
    }

    public function BasicData()
    {
        $dozvole = Permission::all();

        return Datatables::of($dozvole)
            ->editColumn('Naziv', function ($dozvole) {
                return '<a href="dozvole/'.$dozvole->id.'">'.$dozvole->Naziv.'</a>';
            })
            ->addColumn('action', function ($dozvole) {
                $return = "";
                if(Auth::user()->hasRole(['SuperAdmin'])){
                    $return = '<a href="#" class="edit" data-toggle="modal" data-target="#Modal" data-action="dozvole/'.$dozvole->id.'"><span class="glyphicon glyphicon-edit" ></i></a>
                               <a href="dozvole/'.$dozvole->id.'" data-method="delete" data-confirm="Jeste li sigurni?"><i class="glyphicon glyphicon-trash"></i></a>';
                }
                return $return;
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
        $permission = Permission::create($request->all());

        Log::info(Auth::user()->name. ' dodao je dozvolu ' .$permission->name);
        Flash::success('Dozvola je dodana');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission, Request $request)
    {
         return response()->json($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Permission $permission, Request $request)
    {
       $permission->fill($request->all())->save();

        Log::info(Auth::user()->name. ' uredio je dozvolu ' .$permission->name);
        Flash::success('Dozvola je uređena');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Permission $permission
     * @return \Illuminate\Http\Response
     * pošto je veza many to many malo to provjeriti
     */
    public function destroy(Permission $permission)
    {
        $permission->destroy($permission->id);

        Log::info(Auth::user()->name. ' obrisao je dozvolu ' .$permission->name);
        Flash::success('Dozvola je uspješno obrisana');
        return back();
    }
}
