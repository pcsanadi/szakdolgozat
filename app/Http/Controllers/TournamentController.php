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
        $this->middleware('admin')->except('showCalendar');
    }

    /**
     * Show the list of all tournaments
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tournaments = \App\Tournament::withTrashed()->with(['venue'])->get()->sortBy('datefrom');

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
        return view('tournament.show', [ "tournament" => $tournament, "venues" => $venues ]);
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
        $tournament->international = array_key_exists('international',$info);
        $tournament->requested_umpires = $info['requested_umpires'];
        $tournament->save();
        return redirect()->route('tournaments');
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
        $tournament->international = array_key_exists('international',$info);
        $tournament->requested_umpires = $info['requested_umpires'];
        $tournament->save();
        return redirect()->route('tournaments')->with('message','tournament created successsfully');
    }

    /**
     * Show the tournament calendar
     *
     * @return misc
    */
    public function showCalendar()
    {
        $tournaments = \App\Tournament::all()->sortBy('datefrom');
        $newTournaments = array();
        foreach($tournaments as $tournament)
        {
            $newTournament = new \stdClass();
            $newTournament->id = $tournament->id;
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
        $authenticated = !is_null(\Auth::user());
        $user = new \stdClass();
        if( $authenticated )
        {
            $user->admin = \Auth::user()->isAdmin();
            $user->possible_referee = (\Auth::user()->referee_level > 1);
            $user->possible_umpire = (\Auth::user()->umpire_level > 1);
        }
        else
        {
            $user->admin = false;
            $user->possible_referee = false;
            $user->possible_umpire = false;
        }
        return view('tournament.calendar',["tournaments" => $newTournaments, "user" => $user]);
    }
}
