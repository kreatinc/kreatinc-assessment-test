<?php

namespace App\Http\Controllers;
use Facebook\Facebook;
use Illuminate\Http\Request;
use App\Models\Page;

class ConnectController extends Controller
{
    //
    private $api;
    public function __construct()
    {
        $config = config('services.facebook');

        $fb = new Facebook([
            'app_id' => $config['client_id'],
            'app_secret' => $config['client_secret'],
            'default_graph_version' => 'v14.0'
        ]);

        $this->middleware(function ($request, $next) use ($fb) {
            $fb->setDefaultAccessToken(auth()->user()->token);
            $this->api = $fb;
            return $next($request);
        });
    }
    public function index(){
        $res = $this->api->get('/me?fields=accounts');
        $data = $res->getDecodedBody();
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
