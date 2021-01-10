<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Auth;

class AuthController extends Controller
{
    public function login(){
        return view('back.auth.login');
    }

    public function loginpost(Request $request){
     //dd($request->post());
     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
         # code...
          //return 'başarılı'; die;
          toastr()->success('Success','Login Success'.Auth::user()->name);
          return redirect()->route('admin.dashboard');
     }
     return redirect()->route('admin.login')->withErrors('Email or Password Errors!');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
