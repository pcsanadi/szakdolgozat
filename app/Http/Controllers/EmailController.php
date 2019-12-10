<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tournament;
use App\UmpireApplication;
use App\RefereeApplication;

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
        $umpireApplications = UmpireApplication::where(["tournament_id"=>$id,"processed"=>1,"approved"=>1])->get();
        $refereeApplications = RefereeApplication::where(["tournament_id"=>$id,"processed"=>1,"approved"=>1])->get();
        abort_if(   is_null($tournament) or is_null($umpireApplications) or is_null($refereeApplications),
                    500,
                    "Internal Server Error");
        $data = array(  "title" => $tournament->title,
                        "venue" => $tournament->venue->name,
                        "address" => $tournament->venue->address,
                        "courts" => $tournament->venue->courts );
        foreach( $umpireApplications as $application )
        {
            $data["role"] = "umpire";
            \Mail::send( "email.notify", $data, function($message) use($application,$tournament) {
                $message->from("mtlsz-jvb@googlegroups.com");
                $message->to($application->user->email);
                $message->subject("Információ - " . $tournament->title );
            });
        }
        foreach( $refereeApplications as $application )
        {
            $data["role"] = "referee";
            \Mail::send( "email.notify", $data, function($message) use($application,$tournament) {
                $message->from("mtlsz-jvb@googlegroups.com");
                $message->to($application->user->email);
                $message->subject("Információ - " . $tournament->title );
            });
        }

        return \Redirect::back()->with("message","Emails sent successfully");
    }
}
