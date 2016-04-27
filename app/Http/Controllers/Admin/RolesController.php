<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use App\Role;
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

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('ajax',['only' => 'show']);
        $this->middleware('permission.canEdit',['only' => 'show']);
        //['key'] => ['displayTitle',position, 'visible','searchable', 'orderable']
        $tabelaStupci = [
            ['name','name','Naziv Uloge',0,true,true,true],
            ['display_name','display_name','Za prikaz',1,true,false,false],
            ['description','description','Opis',2,true,false,false],
            ['dozvole','dozvole','Dozvole',3,true,false,false],
            ['created_at','created_at','Kreirana',4,true,false,false],
            ['updated_at','updated_at','Ažurirana',5,true,false,false],
            ['action','Akcije','Akcije',6,true,false,false]
        ];
        
        if (!Cache::has("Dozvole")) {
            $dozvole = Permission::all();
            Cache::forever("Dozvole", $dozvole);
        }
        
        view()->share('description', $this->getDescription('Uloge'));


        View::share(['dozvole' =>  Cache::get("Dozvole")] );
        View::share('naslovTabele', 'Uloge');
        View::share('naslovModala', 'Uloga');
        View::share('textDodajGumba', 'Dodaj Ulogu');
        View::share('tabelaStupci', $tabelaStupci);
        View::share('formName', 'uloge');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('datatables.admin.uloge.index');
    }

    public function BasicData()
    {
        $role = Role::with('dozvole');

        return Datatables::of($role)
            ->addColumn('ime', function ($role) {
                return '<a href="admin/dozvole/' . $role->id . '">' . $role->Naziv. '</a>';
            })
            ->addColumn('dozvole', function ($role) {
                $results = "";
                foreach ($role->dozvole as $dozvola) {
                            $results .= '<label class="label label-primary" title="' . $dozvola->description . '">' . $dozvola->name . '</label> ';
                        }
                return $results;
            })
            ->addColumn('action', function ($role) {
                $return = "";
                if(Auth::user()->hasRole(['SuperAdmin'])){
                    $return = '<a href="#" class="edit" data-toggle="modal" data-target="#Modal" data-action="uloge/'.$role->id.'"><span class="glyphicon glyphicon-edit" ></i></a>
                               <a href="uloge/'.$role->id.'" data-method="delete" data-confirm="Jeste li sigurni?"><i class="glyphicon glyphicon-trash"></i></a>';
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
        $role = Role::create($request->all());
        Log::info(Auth::user()->name. ' dodao je ulogu ' .$role->name);
        if($request->input('dozvole')){
            Log::info(Auth::user()->name. ' dodao je dozvole ['.implode(",", $request->input('dozvole')).'] ulozi '.$role->name);
            $this->syncDozvole($role, $request->input('dozvole'));
        }else{
            Log::info(Auth::user()->name. ' maknuo je dozvole ulozi '.$role->name);
            $role->dozvole()->sync([]);
        }
        Flash::success('Uloga je dodana');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role, Request $request)
    {
            return response()->json($role->load('dozvole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Role $role, Request $request)
    {
        $role->update($request->all());
        Log::info(Auth::user()->name. ' uredio je ulogu ' .$role->name);
        if($request->input('dozvole')){
            Log::info(Auth::user()->name. ' promjenio je dozvole ['.implode(",", $request->input('dozvole')).'] ulozi '.$role->name);
            $this->syncDozvole($role, $request->input('dozvole'));
        }else{
            Log::info(Auth::user()->name. ' maknuo je dozvole ulozi '.$role->name);
            $role->dozvole()->sync([]);
        }
        Flash::success('Uloga je uređena');
        return back();
    }

    private function syncDozvole(Role $role, array $dozvole){
        $role->dozvole()->sync($dozvole);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role $role
     * @return \Illuminate\Http\Response
     * pošto je veza many to many malo to provjeriti
     */
    public function destroy(Role $role)
    {
       $role->destroy($role->id);
       Log::info(Auth::user()->name. ' obrisao je ulogu ' .$role->name);
       $role->dozvole()->sync([]);

        Flash::success('Uloga je uspješno obrisana');
        return back();
    }
}
