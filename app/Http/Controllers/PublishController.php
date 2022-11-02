<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use App\Jobs\PublishEmail;
use Carbon\Carbon;
use Facebook\Facebook;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\WeekMail;

class PublishController extends Controller
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
            $this->api = $fb;
            return $next($request);
        });
    }
    public function index(){
        
        $pages = Page::where('user_id', auth()->user()->id)->get();  
        foreach($pages as $page){

    
            $dataArray = Http::withToken($page->token)->get('https://graph.facebook.com/me?fields=posts');
            // dd($dataArray->json());
            if( array_key_exists('posts', $dataArray->json()) ){
                $posts = $dataArray['posts']['data'];
                foreach($posts as $post){
                    $pts = Post::updateOrCreate([
                        'fb_post_id' => $post['id']
                    ],[
                        'message' => $post['message']??'',
                        'scheduled_publish_time' => $post['scheduled_publish_time']??'',
                        'page_id' => $page->id,
                        'created_time' => $post['created_time'],
                    ]);
                }
            }
            

        }
        $posts = Post::whereHas('page', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->latest()->get();
        return view('pages.publish', ['posts'=> $posts, 'pages' => Page::where('user_id', auth()->user()->id )->get() ]);
    }
    public function store(Request $request){
        
        $request->validate([
            'message' => 'string|max:255',
            'file' => 'file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime,image/gif,image/png,image/jpeg,image/jpg',
            'page_id' => 'required|exists:pages,facebook_id',
        ]);
        $page = Page::where('facebook_id',$request->page_id)->first();
        
        $accessToken = $page->token;

        if(!$request->file){
            $res = Http::withToken($page->token)->post('https://graph.facebook.com/me/feed', ['message' => $request->message]);
        }

        if( in_array($request->file->extension(), ['gif','jpeg','png','jpg'])  ){
            $data = [
                'message'=> $request->message,
                'source' => $this->api->fileToUpload($request->file)
            ];
            $res = $this->api->post($request->page_id.'/photos',$data,$page->token );
           
            
        }

        else{
            $data = [
                'message'=> $request->message,
                'source' => $this->api->fileToUpload($request->file)
            ];
            $res = $this->api->post($request->page_id.'/videos',$data,$page->token );

        }
        
        $userEmail = auth()->user()->email;

        PublishEmail::dispatch($userEmail)->delay(10);
            
        return back()->with(['success' => 'post created successully' ]);

    }


    public function storeScheduled(Request $request){
        $request->validate([
            'message' => 'string|max:255',
            'file' => 'file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime,image/gif,image/png,image/jpeg,image/jpg',
            'page_id' => 'required|exists:pages,facebook_id',
            'schudel_date' => 'date|required',
        ]);

        $date = str_replace('T', ' ', $request->schudel_date);

        $unixDate = Carbon::createFromFormat('Y-m-d H:i', $date)->unix();
        $page = Page::where('facebook_id',$request->page_id)->first();
        $accessToken = $page->token;
        if(!$request->file){
            $res = $this->api->post( $request->page_id.'/feed?published=false&message='.$request->message.'&scheduled_publish_time='.$unixDate.'&access_token='.$accessToken);
        
            $post = $res->getDecodedBody();
            Post::create([
                'fb_post_id' => $post['id'],
                'message' => $request->message,
                'scheduled_publish_time' => $request->schudel_date ,
                'page_id' => $page->id,
                'created_time' => Carbon::now(),
            ]);
            Mail::to(auth()->user()->email)->send(new PostCreated);

            return back()->with(['success' => 'post created successully' ]);
        }
        if( in_array($request->file->extension(), ['gif','jpeg','png','jpg'])  ){
            $data = [
                'message'=> $request->message,
                'source' => $this->api->fileToUpload($request->file)
            ];
            $res = $this->api->post($request->page_id.'/photos?published=false&scheduled_publish_time='.$unixDate ,$data,$page->token );
            
        }
        else{
            $data = [
                'message'=> $request->message,
                'source' => $this->api->fileToUpload($request->file)
            ];
            $res = $this->api->post($request->page_id.'/videos?published=false&scheduled_publish_time='.$unixDate,$data,$page->token );
        }
        
        $post = $res->getDecodedBody();
        Post::create([
            'fb_post_id' => $post['id'],
            'message' => $request->message,
            'scheduled_publish_time' => $request->schudel_date ,
            'page_id' => $page->id,
            'created_time' => Carbon::now(),
        ]);
        Mail::to(auth()->user()->email)->send(new PostCreated);

        return back()->with(['success' => 'post created successully' ]);

    }
}
