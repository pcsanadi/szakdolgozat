<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TournamentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("admin")->except("showCalendar");
        $this->middleware("auth")->only("showCalendar");
    }

    /**
     * Show the list of all tournaments
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tournaments = \App\Tournament::withTrashed()
            ->where("dateto",">=",date("Y-m-d"))->get()->sortBy("datefrom");
        if( is_null($tournaments) )
        {
            abort(500,"Internal Server Error");
        }

        return view("tournament.list", [ "tournaments" => $tournaments ])->with("showDeleted",session("showDeleted","false"));
    }

    /**
     * Show one tournament.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request, $id)
    {
        $tournament = \App\Tournament::find($id);
        if( is_null($tournament) )
        {
            return redirect()->route("tournaments")->with("error","tournament not found");
        }
        $venues = \App\Venue::all()->sortBy("name");
        if( is_null($venues) )
        {
            abort(500,"Internal Server Error");
        }
        return view("tournament.edit", [ "tournament" => $tournament, "venues" => $venues ]);
    }

    /**
     * Update a tournament.
     *
     * @return misc
     */
    public function save(Request $request, $id)
    {
        $info = $request->all();
        $tournament = \App\Tournament::find($id);
        if( is_null($tournament)
            or !array_key_exists("title",$info)
            or !array_key_exists("datefrom",$info)
            or !array_key_exists("dateto",$info)
            or !array_key_exists("venue",$info)
            or !array_key_exists("requested_umpires") )
        {
            return redirect()->route("tournaments")->with("error","could not save tournament");
        }
        $tournament->title = $info["title"];
        $tournament->datefrom = $info["datefrom"];
        $tournament->dateto = $info["dateto"];
        $tournament->venue_id = $info["venue"];
        $tournament->requested_umpires = intval($info["requested_umpires"]);
        return $tournament->save()
            ? redirect()->route("tournaments")->with("message","tournament updated successfully")
            : redirect()->route("tournaments")->with("error","could not save tournament");
    }

    /**
     * Restore a previously soft deleted tournament
     *
     * @return misc
     */
    public function restore(Request $request, $id)
    {
        $tournament = \App\Tournament::onlyTrashed()->find($id);
        if(is_null($tournament))
        {
            return redirect()->route("tournaments")->with("error","tournament not found");
        }
        $tournament->restore();
        return redirect()->route("tournaments")->with("showDeleted",$request->input('showDeleted'));
    }

    /**
     * Soft delete a tournament
     *
     * @return misc
     */
    public function destroy(Request $request, $id)
    {
        $tournament = \App\Tournament::find($id);
        if(is_null($tournament))
        {
            return redirect()->route("tournaments")->with("error","tournament not found");
        }
        $tournament->delete();
        return redirect()->route("tournaments")->with("showDeleted",$request->input("showDeleted"));
    }

    /**
     * Show tournament.create view
     *
     * @return misc
     */
    public function create()
    {
        $venues = \App\Venue::all()->sortBy("name");
        if( is_null($venues) )
        {
            abort(500,"Internal Server Error");
        }
        return view("tournament.create", ["venues" => $venues]);
    }

    /**
     * Store a new tournament
     *
     * @return misc
     */
    public function store(Request $request)
    {
        $info = $request->all();
        if( !array_key_exists("title",$info)
            or !array_key_exists("datefrom")
            or !array_key_exists("dateto")
            or !array_key_exists("venue")
            or !array_key_exists("requested_umpires") )
        {
            abort(500,"Internal Server Error");
        }
        $tournament = new \App\Tournament;
        $tournament->title = $info["title"];
        $tournament->datefrom = $info["datefrom"];
        $tournament->dateto = $info["dateto"];
        $tournament->venue_id = intval($info["venue"]);
        $tournament->requested_umpires = intval($info["requested_umpires"]);
        return $tournament->save()
            ? redirect()->route("tournaments")->with("message","tournament created successsfully")
            : redirect()->route("tournaments")->with("error","could not create tournament");
    }

    /**
     * Create desired date interval format
     *
     * @return string
     */
    private function intervalDate( $from, $to )
    {
        $yearfrom = $from->format("Y");
        $monthfrom = $from->format("m");
        $dayfrom = $from->format("d");
        $yearto = $to->format("Y");
        $monthto = $to->format("m");
        $dayto = $to->format("d");
        $ret = $yearfrom . ". " . $monthfrom . ". " . $dayfrom . " - ";
        if( $yearfrom != $yearto )
            return  $ret . $yearto . ". " . $monthto . ". " . $dayto . ".";
        else if( $monthfrom != $monthto )
            return $ret . $monthto . ". " . $dayto . ".";
        else if( $dayfrom != $dayto )
            return $ret . $dayto . ".";
        else
            return $from->format("Y. m. d.");
    }

    /**
     * Show the tournament calendar
     *
     * @return misc
    */
    public function showCalendar(Request $request, $id = 0)
    {
        $info = $request->all();

        if( array_key_exists("season", $info ) )
        {
            $season = intval($info["season"]);
        }
        else
        {
            $season = ( ( intval(date("m")) >= 9 ) ? intval(date("Y")) : intval(date("Y") - 1 ) );
        }

        $filtered = ( $id != 0 );

        $tournaments = \App\Tournament::with(["umpireApplications.user","refereeApplications.user"])
            ->where("datefrom",">=",strval($season)."-09-01")
            ->where("dateto","<=",strval($season+1)."-08-31")
            ->get()
            ->sortBy("datefrom");
        if( is_null($tournaments) )
        {
            abort(500,"Internal Server Error");
        }
        $newTournaments = array();
        $userId = ( $filtered ? $id : \Auth::user()->id );

        foreach($tournaments as $tournament)
        {
            $appliedAsReferee = false;
            $umpireApplicationProcessed = false;
            $umpireApplicationApproved = false;

            $appliedAsUmpire = false;
            $refereeApplicationProcessed = false;
            $refereeApplicationApproved = false;

            $skip = true;
            foreach($tournament->umpireApplications as $application)
            {
                if( $application->user->id == $userId )
                {
                    $skip = false;
                    $appliedAsUmpire = true;
                    $umpireApplicationProcessed = $application->processed;
                    $umpireApplicationApproved = $application->approved;
                    break;
                }
            }
            foreach($tournament->refereeApplications as $application)
            {
                if( $application->user->id == $userId )
                {
                    $skip = false;
                    $appliedAsReferee = true;
                    $refereeApplicationProcessed = $application->processed;
                    $refereeApplicationApproved = $application->approved;
                    break;
                }
            }
            if($filtered and $skip)
            {
                continue;
            }
            
            $newTournament = new \stdClass();
            $newTournament->id = $tournament->id;
            $newTournament->appliedAsUmpire = $appliedAsUmpire;
            $newTournament->umpireApplicationProcessed = $umpireApplicationProcessed;
            $newTournament->umpireApplicationApproved = $umpireApplicationApproved;
            $newTournament->appliedAsReferee = $appliedAsReferee;
            $newTournament->refereeApplicationProcessed = $refereeApplicationProcessed;
            $newTournament->refereeApplicationApproved = $refereeApplicationApproved;
            $newTournament->date = $this->intervalDate($tournament->datefrom,$tournament->dateto);
            $newTournament->title = $tournament->title;
            $newTournament->venue = $tournament->venue;
            $newTournament->requested_umpires = $tournament->requested_umpires;
            $newTournament->past = ( date("Ymd") > $tournament->datefrom->format("Ymd") );
            $newTournament->umpireApplications = $tournament->umpireApplications;
            if( !is_null($newTournament->umpireApplications) )
            {
                $newTournament->umpireApplications = $newTournament->umpireApplications->sort();
            }
            $newTournament->refereeApplications = $tournament->refereeApplications;
            if( !is_null($newTournament->refereeApplications) )
            {
                $newTournament->refereeApplications = $newTournament->refereeApplications->sort();
            }
            array_push($newTournaments,$newTournament);
        }

        $user = new \stdClass();
        $user->admin = \Auth::user()->admin;
        $user->id = \Auth::user()->id;
        $user->possible_referee = (\Auth::user()->referee_level > 1);
        $user->possible_umpire = (\Auth::user()->umpire_level > 1);

        return view("tournament.calendar",[ "tournaments" => $newTournaments,
                                            "user" => $user,
                                            "filtered" => $filtered,
                                            "season" => $season]);
    }
}
