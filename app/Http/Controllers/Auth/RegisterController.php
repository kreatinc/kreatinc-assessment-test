<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class RegisterController extends Controller
{
    //
    public function index(){
        return view('auth.register');
    }
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password'=> 'string|confirmed|min:8|max:255',
        ]);
        $user = User::where('email' , $request->email )->first();
        if(!$user){
            $NewUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password'=> bcrypt($request->password),
            ]);
            Auth::login($NewUser);
            return redirect('/');
        }
        else{
            return back()->with(['message' => 'you have already an account, please sing in ']);
        }
    }
}
