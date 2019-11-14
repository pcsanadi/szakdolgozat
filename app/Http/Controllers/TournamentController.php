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
}
