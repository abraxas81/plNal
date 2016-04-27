<?php

namespace App\Http\Controllers\Admin;

use App\Klijent;
use App\Role;
use App\User;
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

class UsersController extends Controller
{

    protected $klasa = 'Operateri';

  public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ajax',['only' => 'show']);
        $this->middleware('role.canEditUser',['only' => 'show']);
        //['key'] => ['displayTitle',position, 'visible','searchable', 'orderable']



        $tabelaStupci = [
            ['name','Operateri.name','Naziv Operatera',0,true,true,true],
            ['roles','roles.name','Uloge',1,true,false,false],
            ['dozvole','roles.dozvole.name','Dozvole',2,true,false,false],
            ['created_at','Operateri.created_at','Kreiran',3,true,false,false],
            ['updated_at','Operateri.updated_at','Ažuriran',4,true,false,false],
            ['action','Akcije','Akcije',5,true,false,false]
        ];

        if (!Cache::has("Uloge")) {
            $role = Role::all();
            Cache::forever("Uloge", $role);
        }


        view()->share('description', $this->klasa);
        View::share(['uloge' =>  Cache::get("Uloge")]);
        View::share(['klijenti' =>  Klijent::all()]);
        View::share('naslovTabele', $this->klasa);
        View::share('naslovModala', 'Operater');
        View::share('textDodajGumba', 'Dodaj Operatera');
        View::share('tabelaStupci', $tabelaStupci);
        View::share('formName', $this->klasa);
        view()->share('sidebarSelection' , $this->klasa);
    }

   public function index(){
       return view('datatables.admin.operateri.index');
   }

   public function BasicData()
   {
       $operateri = User::with('roles','roles.dozvole');
       return Datatables::of($operateri)
            ->addColumn('action', function ($operateri) {
                return '<a href="#" class="edit" title="Uredi" data-toggle="modal" data-target="#Modal" data-action="operateri/'.$operateri->id.'"><span class="glyphicon glyphicon-edit"></a>
                        <a href="operateri/'.$operateri->id.'" title="Obriši" data-method="delete" data-confirm="Jeste li sigurni?"><i class="glyphicon glyphicon-trash"></i></a>';
            })
           ->addColumn('roles', function ($operateri) {
               $results="";
               foreach ($operateri->roles as $role){
                   $results.='<label class="label label-primary" title="'.$role->description.'">'.$role->name.'</label> ';
               }
           return $results;
           })
           ->addColumn('dozvole', function ($operateri) {
               $results = "";
               $array =[];
               foreach ($operateri->roles as $role) {
                   foreach ($role->dozvole as $dozvola){
                       if(!in_array($dozvola->id, $array)){
                           array_push($array,$dozvola->id);
                           $results .= '<label class="label label-primary" title="'.$dozvola->description.'">' . $dozvola->name . '</label> ';
                       }
                   }
               }
               return $results;
           })
           ->make(true);
   }

   public function show(User $user, Request $request){
       if ($request->has('osobniPodaci')) {
               return response()->json($user);
           } else {
               return response()->json($user->load(['roles', 'roles.dozvole', 'klijenti']));
           }
   }

   public function store(Request $request){
       $user = User::create($request->all());
       Log::info(Auth::user()->name. ' dodao je korisnika ' .$user->name);
       if($request->input('roles')){
           Log::info(Auth::user()->name. ' promjenio je uloge ['.implode(",", $request->input('roles')).'] korisniku ' .$user->name);
           $this->syncUloge($user, $request->input('roles'));
       } else {
           $user->roles()->sync([]);
           Log::info(Auth::user()->name. ' maknuo je ulogu/e korisniku ' .$user->name);
       }
       if($request->input('klijenti')) {
           $this->syncKlijenti($user, $request->input('klijenti'));
           Log::info(Auth::user()->name. ' pridružio je klijenta/e ['.implode(",", $request->input('klijenti')).'] korisniku ' .$user->name);
       } else {
           $user->klijenti()->sync([]);
           Log::info(Auth::user()->name. ' maknuo je klijenta/e korisniku ' .$user->name);
       }
       Flash::success('Operater je dodan');
       return back();
   }

   public function update(User $user, Request $request){
       if($request->get('password') != ''){
           $user->update($request->all());
       } else {
           $user->update($request->except(['password']));
       }
       if($request->input('roles')){
           Log::info(Auth::user()->name. ' promjenio je uloge ['.implode(",", $request->input('roles')).'] korisniku ' .$user->name);
           $this->syncUloge($user, $request->input('roles'));
       } else {
           Log::info(Auth::user()->name. ' maknuo je ulogu/e korisniku ' .$user->name);
           $user->roles()->sync([]);
       }
       if($request->input('klijenti')) {
           $this->syncKlijenti($user, $request->input('klijenti'));
           Log::info(Auth::user()->name. ' promjenio je klijenta/e ['.implode(",", $request->input('klijenti')).'] korisniku ' .$user->name);
       } else {
           $user->klijenti()->sync([]);
           Log::info(Auth::user()->name. ' maknuo je klijenta/e korisniku ' .$user->name);
       }
       Flash::success('Operater je uređen');
       Log::info(Auth::user()->name.' uredio je operatera '.$user->name);
       return back();
   }

    private function syncUloge(User $user, array $role){
        $user->roles()->sync($role);
    }

    private function syncKlijenti(User $user, array $klijenti){
        $user->klijenti()->sync($klijenti);
    }

   public function destroy(User $user){
            $user->delete($user->id);
            Log::info(Auth::user()->name. ' izbrisao je korisnika ' .$user->name);
            $user->roles()->sync([]);
            $user->klijenti()->sync([]);
       Flash::success('Operater je uspješno obrisan');
       return back();
   }
}

