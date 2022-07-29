<?php

namespace App\Http\Controllers\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class LoginController extends Controller
{
    //
    public function index(){
        return view('auth.login');
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email )->first();
        if($user){
            if(hash::check($request->password, $user->password)){
                Auth::login($user);
                return redirect('/');
            }
            else{
                return back()->with(['error' => 'you enter wrong credits !']);
            }
        }
        else{
            return back()->with(['error' => 'you have no account please create new one !']);
        }
        
    }

    public function FacebookRedirect(){
        return Socialite::driver('facebook')->scopes([
            "public_profile, pages_show_list", "pages_read_engagement", "pages_manage_posts", "pages_manage_metadata", "user_videos", "user_posts"
        ])->redirect();
    }
    public function FacebookCallback(){
        $userFacebook = Socialite::driver('facebook')->user();
        $user = User::updateOrCreate([
            'facebook_id' => $userFacebook->id,
        ], [
            'name' => $userFacebook->name,
            'email' => $userFacebook->email??'testUesr@gmail.com',
            'token' => $userFacebook->token,
            'password' => bcrypt($userFacebook->email)
        ]);
     
        Auth::login($user);
     
        return redirect('/');
    }
}
