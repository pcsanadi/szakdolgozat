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
        $tournaments = \App\Tournament::withTrashed()->get()->sortBy("datefrom");

        return view('tournament.list', [ "tournaments" => $tournaments ])->with("showDeleted",session("showDeleted","false"));
    }

    /**
     * Show one tournament.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request, $id)
    {
        $tournament = \App\Tournament::find($id);
        if ( is_null($tournament) )
        {
            return redirect()->route('tournaments')->with('error','tournament not found');
        }
        $venues = \App\Venue::all()->sortBy('name');
        return view('tournament.edit', [ "tournament" => $tournament,
                                        "venues" => $venues ]);
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
        if(is_null($tournament))
        {
            return redirect()->route('tournaments')->with('error','tournament not found');
        }
        $tournament->title = $info['title'];
        $tournament->datefrom = $info['datefrom'];
        $tournament->dateto = $info['dateto'];
        $tournament->venue_id = $info['venue'];
        $tournament->requested_umpires = $info['requested_umpires'];
        $tournament->save();
        return redirect()->route('tournaments')->with('message','tournament updated successfully');
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
            return redirect()->route('tournaments')->with('error','tournament not found');
        }
        $tournament->restore();
        return redirect()->route('tournaments')->with("showDeleted",$request->input('showDeleted'));
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
            return redirect()->route('tournaments')->with('error','tournament not found');
        }
        $tournament->delete();
        return redirect()->route('tournaments')->with("showDeleted",$request->input('showDeleted'));
    }

    /**
     * Show tournament.create view
     *
     * @return misc
     */
    public function create()
    {
        $venues = \App\Venue::all()->sortBy('name');
        return view('tournament.create', ["venues" => $venues]);
    }

    /**
     * Store a new tournament
     *
     * @return misc
     */
    public function store(Request $request)
    {
        $info = $request->all();
        $tournament = new \App\Tournament;
        $tournament->title = $info['title'];
        $tournament->datefrom = $info['datefrom'];
        $tournament->dateto = $info['dateto'];
        $tournament->venue_id = $info['venue'];
        $tournament->requested_umpires = $info['requested_umpires'];
        $tournament->save();
        return redirect()->route('tournaments')->with('message','tournament created successsfully');
    }

    /**
     * Show the tournament calendar
     *
     * @return misc
    */
    public function showCalendar($id = 0)
    {
        $filtered = ( $id != 0 );
        $tournaments = \App\Tournament::with(['umpireApplications.user','refereeApplications.user'])->get()->sortBy('datefrom');
        $newTournaments = array();
        $userId = ( $filtered ? $id : \Auth::user()->id );
        foreach($tournaments as $tournament)
        {
            $appliedAsReferee = false;
            $appliedAsUmpire = false;
            $skip = true;
            foreach($tournament->umpireApplications as $application)
            {
                if( $application->user->id == $userId )
                {
                    $skip = false;
                    $appliedAsUmpire = true;
                    break;
                }
            }
            foreach($tournament->refereeApplications as $application)
            {
                if( $application->user->id == $userId )
                {
                    $skip = false;
                    $appliedAsReferee = true;
                    break;
                }
            }
            if($filtered and $skip)
                continue;
            $newTournament = new \stdClass();
            $newTournament->id = $tournament->id;
            $newTournament->appliedAsUmpire = $appliedAsUmpire;
            $newTournament->appliedAsReferee = $appliedAsReferee;
            // date
            if( $tournament->datefrom === $tournament->dateto )
                $newTournament->date = date_format(date_create($tournament->datefrom),"Y. m. d.");
            else
            {
                $datefrom = new \DateTime($tournament->datefrom);
                $dateto = new \DateTime($tournament->dateto);
                $yearfrom = $datefrom->format("Y");
                $yearto = $dateto->format("Y");
                $monthfrom = $datefrom->format("m");
                $monthto = $dateto->format("m");
                $dayfrom = $datefrom->format("d");
                $dayto = $dateto->format("d");
                $newTournament->date = $yearfrom . ". " . $monthfrom . ". " . $dayfrom . " - ";
                if( $yearfrom != $yearto )
                    $newTournament->date .= $yearto . ". " . $monthto . ". " . $dayto . ".";
                else if( $monthfrom != $monthto )
                    $newTournament->date .= $monthto . ". " . $dayto . ".";
                else
                    $newTournament->date .= $dayto . ".";
            }
            $newTournament->title = $tournament->title;
            $newTournament->venue = $tournament->venue;
            $newTournament->requested_umpires = $tournament->requested_umpires;
            $newTournament->umpireApplications = $tournament->umpireApplications;
            if( !is_null($newTournament->umpireApplications) )
                $newTournament->umpireApplications = $newTournament->umpireApplications->sort();
            $newTournament->refereeApplications = $tournament->refereeApplications;
            if( !is_null($newTournament->refereeApplications) )
                $newTournament->refereeApplications = $newTournament->refereeApplications->sort();
            array_push($newTournaments,$newTournament);
        }
        $user = new \stdClass();
        $user->admin = \Auth::user()->admin;
        $user->possible_referee = (\Auth::user()->referee_level > 1);
        $user->possible_umpire = (\Auth::user()->umpire_level > 1);
        return view('tournament.calendar',["tournaments" => $newTournaments, "user" => $user, "filtered" => $filtered]);
    }
}
