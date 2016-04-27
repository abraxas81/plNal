<?php

namespace App\Http\Controllers\Operater;

use App\User;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('ajax',['only' => 'show']);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function update(User $user, Request $request){
            if($request->get('password') != ''){
                $user->update($request->all());
                Log::info($user->name. ' promjenio je lozinku');
            } else {
                $user->update($request->except(['password']));
                Log::info($user->name. ' promjenio je podatke');
            }
        Flash::success('Uredili ste osobne podatke');
        
        return back();
    }

}


