<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Page;
class WeekMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * 
     * Create a new message instance.
     *
     * @return void
     */
    public $user; 
    public $pages;

    public function __construct($id)
    {
        $this->user = User::find($id);
        
        $this->pages =Page::with('posts')->where('user_id' , $id)->get();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mail from Test Assessment')->markdown('mails.weekMail');
    }
}
