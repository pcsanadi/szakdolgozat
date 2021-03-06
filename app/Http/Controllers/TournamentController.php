<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Tournament;
use App\Venue;

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
        $tournaments = Tournament::withTrashed()
            ->where("dateto",">=",date("Y-m-d"))->get()->sortBy("datefrom");
        abort_if(is_null($tournaments),500,"Internal Server Error");
        return view("tournament.list", [ "tournaments" => $tournaments ])->with("showDeleted",session("showDeleted","false"));
    }

    /**
     * Show one tournament.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $tournament = Tournament::find($id);
        if( is_null($tournament) )
        {
            return redirect()->route("tournaments.index")->with("error","tournament not found");
        }
        $venues = Venue::all()->sortBy("name");
        abort_if(is_null($venues),500,"Internal Server Error");
        return view("tournament.edit", [ "tournament" => $tournament, "venues" => $venues ]);
    }

    /**
     * Update a tournament.
     *
     * @return misc
     */
    public function update(Request $request, $id)
    {
        $this->validator($request)->validate();
        $tournament = Tournament::find($id);
        if( is_null($tournament) or !$request->has(["title","datefrom","dateto","venue","requested_umpires"]) )
        {
            return redirect()->route("tournaments.index")->with("error","could not update tournament");
        }
        $tournament->title = $request->title;
        $tournament->datefrom = $request->datefrom;
        $tournament->dateto = $request->dateto;
        $tournament->venue_id = $request->venue;
        $tournament->requested_umpires = intval($request->requested_umpires);
        return $tournament->save()
            ? redirect()->route("tournaments.index")->with("message","tournament updated successfully")
            : redirect()->route("tournaments.index")->with("error","could not update tournament");
    }

    /**
     * Restore a previously soft deleted tournament
     *
     * @return misc
     */
    public function restore(Request $request, $id)
    {
        $tournament = Tournament::onlyTrashed()->find($id);
        if(is_null($tournament))
        {
            return redirect()->route("tournaments.index")->with("error","tournament not found");
        }
        $tournament->restore();
        return redirect()->route("tournaments.index")->with("showDeleted",$request->showDeleted);
    }

    /**
     * Soft delete a tournament
     *
     * @return misc
     */
    public function destroy(Request $request, $id)
    {
        return Tournament::destroy($id)
            ? redirect()->route("tournaments.index")->with("showDeleted",$request->showDeleted)
            : redirect()->route("tournaments.index")->with(["showDeleted" => $request->showDeleted, "error" => "could not delete tournament"]);
    }

    /**
     * Show tournament.create view
     *
     * @return misc
     */
    public function create()
    {
        $venues = Venue::all()->sortBy("name");
        abort_if( is_null($venues),500,"Internal Server Error");
        return view("tournament.edit", ["venues" => $venues]);
    }

    /**
     * Store a new tournament
     *
     * @return misc
     */
    public function store(Request $request)
    {
        $this->validator($request)->validate();
        abort_unless(!$request->has(["title","datefrom","dateto","venue","requested_umpires"]),500,"Internal Server Error");
        $tournament = new Tournament;
        $tournament->title = $request->title;
        $tournament->datefrom = $request->datefrom;
        $tournament->dateto = $request->dateto;
        $tournament->venue_id = intval($request->venue);
        $tournament->requested_umpires = intval($request->requested_umpires);
        return $tournament->save()
            ? redirect()->route("tournaments.index")->with("message","tournament created successsfully")
            : redirect()->route("tournaments.index")->with("error","could not create tournament");
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
        if( $request->has("season") )
        {
            $season = intval($request->season);
        }
        else
        {
            $season = ( ( intval(date("m")) >= 9 ) ? intval(date("Y")) : intval(date("Y") - 1 ) );
        }

        $filtered = ( $id != 0 );

        $tournaments = Tournament::with(["umpireApplications.user","refereeApplications.user"])
            ->where("datefrom",">=",strval($season)."-09-01")
            ->where("dateto","<=",strval($season+1)."-08-31")
            ->get()
            ->sortBy("datefrom");
        abort_if(is_null($tournaments),500,"Internal Server Error");
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
                $newTournament->umpireApplications = $newTournament->umpireApplications->sortBy('user.name');
            }
            $newTournament->refereeApplications = $tournament->refereeApplications;
            if( !is_null($newTournament->refereeApplications) )
            {
                $newTournament->refereeApplications = $newTournament->refereeApplications->sortBy('user.name');
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

    /**
     * Create a validator and validate the request
     *
     * @param Illuminate\Http\Request
     *
     */
    private function validator(Request $request)
    {
        $rules = [
            "title" => "required",
            "datefrom" => "bail|required|date|before_or_equal:dateto",
            "dateto" => "bail|required|date|after_or_equal:datefrom",
            "venue" => "required",
            "requested_umpires" => "numeric",
        ];
        return Validator::make( $request->all(), $rules );
    }
}
