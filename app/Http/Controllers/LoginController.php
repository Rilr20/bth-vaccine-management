<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index() 
    {
        return view('login.login', ['title' => 'Inloggning']);
    }

    public function checklogin(Request $request) 
    {
        // dd($request);
        
        $userData = array(
            'email' => $request->get('email'),
            'password' => $request->get('password')
        );

        if(Auth::attempt($userData)) 
        {
            return redirect('/staff');
        }

        // else {
            // return back()->with('wrong', 'Fel inloggning');
        return view('login.login', ['wrong' => 'Login or password is invalid', 'title' => 'Login']);
        // }
    }
    public function logout() {
        Auth::logout();
        return redirect('/');
    }
    public function create()
    {
        return view('staff.create');
    }
    public function store(Request $request)
    {
        $user = User::make([
            'fullname'=> $request->input($request->fullname),
            'password'=> Hash::make($request->newPassword),
            'is_admin'=> $request->input($request->is_admin),
            'email'=> $request->input($request->email)
        ]);
        $user->save();
        return redirect('/staff');
    }
}