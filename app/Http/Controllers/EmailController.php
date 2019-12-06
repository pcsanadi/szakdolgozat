<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tournament;

class EmailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("admin");
    }

    public function sendmail($id)
    {
        $tournament = Tournament::find($id);
        abort_if(is_null($tournament),500,"Internal Server Error");
        $data = array(  "title" => $tournament->title,
                        "venue" => $tournament->venue->name,
                        "address" => $tournament->venue->address,
                        "courts" => $tournament->venue->courts );
        \Mail::send('email.notify', $data, function ($message)
        {
            $message->from('from@daemon.com');
            $message->to('to@otherdaemon.com', 'John Smith')->subject('Welcome!');
        });

        return \Redirect::back();
    }
}
