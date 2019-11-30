<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RefereeApplication;
use App\UmpireApplication;
use App\Tournament;

class ApplicationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("auth");
    }

    /**
     * Apply to a tournament as an umpire
     */
    public function addUmpire($id)
    {
        return $this->add($id,"umpire");
    }

    /**
     * Remove an umpire application for a tournament
     */
    public function removeUmpire(Request $request, $id)
    {
        return $this->remove($request,$id,"umpire");
    }

    /**
     * Apply to a tournament as a referee
     */
    public function addReferee($id)
    {
        return $this->add($id,"referee");
    }

    /**
     * Remove a referee application for a tournament
     */
    public function removeReferee(Request $request, $id)
    {
        return $this->remove($request,$id,"referee");
    }

    /**
     * Show list of applications for a tournament
     */
    public function show($id)
    {
        $umpireApplications = UmpireApplication::where("tournament_id",$id)->get();
        $refereeApplications = RefereeApplication::where('tournament_id',$id)->get();
        $tournament = Tournament::find($id);
        abort_if( is_null($umpireApplications) or is_null($refereeApplications) or is_null($tournament),500,"Internal Server Error");

        return view("tournament.applications",[ "umpireApplications" => $umpireApplications,
                                                "refereeApplications" => $refereeApplications,
                                                "tournament" => $tournament ]);
    }

    /**
     * Save application details
     */
    public function store(Request $request, $id)
    {
        $info = $request->all();
        // loop through all the applications of the tournament and check if we got information of them
        $umpireApplications = UmpireApplication::where("tournament_id",$id)->get();
        $refereeApplications = RefereeApplication::where("tournament_id",$id)->get();
        abort_if(is_null($umpireApplications) or is_null($refereeApplications),500,"Internal Server Error");
        foreach($umpireApplications as $application)
        {
            $processed_name = "umpire_application_processed_" . strval($application->id) . "_value";
            $application->processed = ( array_key_exists($processed_name,$info) and ( $info[$processed_name] == "1" ) );
            $approved_name = "umpire_application_approved_" . strval($application->id) . "_value";
            $application->approved = ( array_key_exists($approved_name,$info) and ( $info[$approved_name] == "1" ) );
            abort_unless($application->save(),500,"Internal Server Error");
        }
        foreach($refereeApplications as $application)
        {
            $processed_name = "referee_application_processed_" . strval($application->id) . "_value";
            $application->processed = ( array_key_exists($processed_name,$info) and ( $info[$processed_name] == "1" ) );
            $approved_name = "referee_application_approved_" . strval($application->id) . "_value";
            $application->approved = ( array_key_exists($approved_name,$info) and ( $info[$approved_name] == "1" ) );
            abort_unless($application->save(),500,"Internal Server Error");
        }
        return redirect()->route("tournaments.index");
    }

    /**
     * Remove application from database
     */
    private function remove(Request $request, $id, $type)
    {
        $filtered = $request->input("filtered");
        abort_if(is_null($filtered),500,"Internal Server Error");
        $userId = \Auth::user()->id;
        switch ($type)
        {
            case "referee":
                $application =RefereeApplication::where(["tournament_id"=>$id,"umpire_id"=>$userId])->first();
                break;
            case "umpire":
                $application = UmpireApplication::where(["tournament_id"=>$id,"umpire_id"=>$userId])->first();
                break;
            default:
                abort(500,"Internal Server Error");
        }
        $application = UmpireApplication::where(["tournament_id"=>$id,"umpire_id"=>$userId])->first();
        if( is_null($application) )
        {
            return $filtered
                ? redirect()->route("calendar",$userId)->with("error","application not found")
                : redirect()->route("calendar")->with("error","application not found");
        }
        $application->delete();
        return $filtered
            ? redirect()->route("calendar",$userId)
            : redirect()->route("calendar");
    }

    /**
     * Add application to database
     */
    private function add($id,$type)
    {
        $userId = \Auth::user()->id;
        $tournament = Tournament::find($id);
        if( is_null($tournament) )
        {
            return redirect()->route("calendar")->with("error","tournament not found");
        }
        abort_unless( $tournament->isFuture(),403,"Application to a tournament in the past.");
        switch ($type)
        {
            case "umpire":
                if( UmpireApplication::where(["tournament_id"=>$id,"umpire_id"=>$userId])->count() > 0 )
                {
                    return redirect()->route("calendar")->with("error","application already in database");
                }
                $application = new UmpireApplication;
                $application->umpire_id = $userId;
                break;
            case "referee":
                if( RefereeApplication::where(["tournament_id"=>$id,"referee_id"=>$userId])->count() > 0 )
                {
                    return redirect()->route("calendar")->with("error","application already in database");
                }
                $application = new RefereeApplication;
                $application->referee_id = $userId;
                break;
            default:
                abort(500,"Internal Server Error");
        }
        $application->tournament_id = $id;
        $application->approved = false;
        $application->processed = false;
        return $application->save()
            ? redirect()->route("calendar")
            : redirect()->route("calendar")->with("error","could not save application");
    }
}
