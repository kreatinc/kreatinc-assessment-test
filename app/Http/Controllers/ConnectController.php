<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Page;
use Facebook\Facebook;

class ConnectController extends Controller
{
    //


    
    public function index(){
        

        $token = auth()->user()->token;
        $data = Http::withToken($token)->get('https://graph.facebook.com/v15.0/me?fields=accounts');

        $pages = $data['accounts']['data'];
        foreach($pages as $page){
            Page::updateOrCreate([
                    'facebook_id' => $page['id'] ],
                [
                    'name' => $page['name'],
                    'token' => $page['access_token'],
                    'facebook_id' => $page['id'],
                    'user_id' => auth()->user()->id
                ]
            );
    
        }
        $pages = Page::where('user_id', auth()->user()->id )->get();
        return view('pages.connect', ['pages' => $pages ]);
    }
}
