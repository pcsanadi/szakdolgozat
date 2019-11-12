<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VenueController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin'); // always use the 'admin' middleware for this controller
    }

    /**
     * Show the list of all venues.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $venues = \App\Venue::withTrashed()->get();

        return view('venue.list', [ "venues" => $venues ]);
    }

    /**
     * Show venue.create view
     *
     * @return misc
     */
    public function create()
    {
        return view('venue.create');
    }

    /**
     * Store a new venue
     *
     * @return misc
     */
    public function store(Request $request)
    {
        $info = $request->all();
        if( 0 != \App\Venue::where('name',$info['name'])->orWhere('address',$info['address'])->count() )
        {
            return redirect()->route('venues')->with('error','venue with this name or address already exists');
        }
        $venue = new \App\Venue;
        $venue->name = $info['name'];
        $venue->address = $info['address'];
        $venue->courts = $info['courts'];
        $venue->accredited = array_key_exists('accredited', $info);

        $venue->save();

        return redirect()->route('venues')->with('message','venue created successsfully');
    }
}
