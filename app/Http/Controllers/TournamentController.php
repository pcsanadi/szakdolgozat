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
        $this->middleware('admin');
    }

    /**
     * Show the list of all tournaments
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tournaments = \App\Tournament::withTrashed()
                                    ->with(['venue'])->get();

        return view('tournament.list', [ "tournaments" => $tournaments ])->with("showDeleted",session("showDeleted","false"));
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
}