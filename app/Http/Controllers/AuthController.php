<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    //

    public function index()
    {

        return view('auth.login');

    }


    public function login(Request $req)
    {
        // dd($req->all());

     $req->validate([

            "email" => "required",
            "password" => "required",
        ]);

        //login code

        if(\Auth::attempt($req->only('email','password')))
        {
            return redirect('home');
        }
        return redirect('login')->withErrors('Error');

    }


    public function rigister_view()
    {

        return view('auth.register');
    }


    public function register(Request $req)
    {
        // dd($req->all());

        $req->validate([
            "name" => "required",
            "email" => "required",
            "password" => "required|confirmed",
        ]);

        //save in user table
        User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => \Hash::make($req->password),

        ]);


        //login user here

        if(\Auth::attempt($req->only('email','password')))
        {
            return redirect('home');
        }
        return redirect('register')->withErrors('Login details not valid');

    }


    public function home()
    {
        return view('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}

