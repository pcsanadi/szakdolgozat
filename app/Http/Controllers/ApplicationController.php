<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Apply to a tournament as an umpire
     */
    public function addUmpire($id)
    {
        $userId = \Auth::user()->id;
        $tournament = \App\Tournament::find($id);
        if( null == $tournament )
        {
            return redirect()->route("calendar")->with("error","tournament not found");
        }
        if( !$tournament->isFuture() )
        {
            abort(403,"Application to a tournament in the past.");
        }
        if( \App\UmpireApplication::where(['tournament_id'=>$id,'umpire_id'=>$userId])->count() > 0 )
        {
            return redirect()->route('calendar')->with('error','application already in database');
        }
        $application = new \App\UmpireApplication;
        $application->umpire_id = $userId;
        $application->tournament_id = $id;
        $application->approved = null;
        $application->save();
        return redirect()->route('calendar');
    }

    /**
     * Remove an umpire application for a tournament
     */
    public function removeUmpire(Request $request, $id)
    {
        $filtered = $request->input('filtered');
        $userId = \Auth::user()->id;
        $application = \App\UmpireApplication::where(['tournament_id'=>$id,'umpire_id'=>$userId])->first();
        if( is_null($application) )
        {
            return $filtered
                ? redirect()->route('calendar',$userId)->with('error','application not found')
                : redirect()->route('calendar')->with('error','application not found');
        }
        $application->delete();
        return $filtered ? redirect()->route('calendar',$userId) : redirect()->route('calendar');
    }

    /**
     * Apply to a tournament as a referee
     */
    public function addReferee($id)
    {
        $userId = \Auth::user()->id;
        if( null == $tournament )
        {
            return redirect()->route("calendar")->with("error","tournament not found");
        }
        if( !$tournament->isFuture() )
        {
            abort(403,"Application to a tournament in the past.");
        }
        if( \App\RefereeApplication::where(['tournament_id'=>$id,'referee_id'=>$userId])->count() > 0 )
        {
            return redirect()->route('calendar')->with('error','application already in database');
        }
        $application = new \App\RefereeApplication;
        $application->referee_id = $userId;
        $application->tournament_id = $id;
        $application->approved = null;
        $application->save();
        return redirect()->route('calendar');
    }

    /**
     * Remove a referee application for a tournament
     */
    public function removeReferee(Request $request, $id)
    {
        $filtered = $request->input('filtered');
        $userId = \Auth::user()->id;
        $application = \App\RefereeApplication::where(['tournament_id'=>$id,'referee_id'=>$userId])->first();
        if( is_null($application) )
        {
            return $filtered
                ? redirect()->route('calendar',$userId)->with('error','application not found')
                : redirect()->route('calendar')->with('error','application not found');
        }
        $application->delete();
        return $filtered ? redirect()->route('calendar',$userId) : redirect()->route('calendar');
    }

    /**
     * Show list of applications for a tournament
     */
    public function show($id)
    {
        $umpireApplications = \App\UmpireApplication::where('tournament_id',$id)->get();
        $refereeApplications = \App\RefereeApplication::where('tournament_id',$id)->get();
        $tournament = \App\Tournament::find($id);

        return view("tournament.applications",[ "umpireApplications" => $umpireApplications,
                                                "refereeApplications" => $refereeApplications,
                                                "tournament" => $tournament ]);
    }

    /**
     * Save application details
     */
    public function save(Request $request, $id)
    {
        $info = $request->all();
        // loop through all the applications of the tournament and check if we got information of them
        $umpireApplications = \App\UmpireApplication::where('tournament_id',$id)->get();
        $refereeApplications = \App\RefereeApplication::where('tournament_id',$id)->get();
        foreach($umpireApplications as $application)
        {
            $processed_name = "umpire_application_processed_" . strval($application->id) . "_value";
            $application->processed = ( array_key_exists($processed_name,$info) and ( $info[$processed_name] == "1" ) );
            $approved_name = "umpire_application_approved_" . strval($application->id) . "_value";
            $application->approved = ( array_key_exists($approved_name,$info) and ( $info[$approved_name] == "1" ) );
            $application->save();
        }
        foreach($refereeApplications as $application)
        {
            $processed_name = "referee_application_processed_" . strval($application->id) . "_value";
            $application->processed = ( array_key_exists($processed_name,$info) and ( $info[$processed_name] == "1" ) );
            $approved_name = "referee_application_approved_" . strval($application->id) . "_value";
            $application->approved = ( array_key_exists($approved_name,$info) and ( $info[$approved_name] == "1" ) );
            $application->save();
        }
        return redirect()->route('tournaments');
    }
}
