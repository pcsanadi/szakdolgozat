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

        return view('venue.list', [ "venues" => $venues ])->with("showDeleted",session("showDeleted","false"));
    }

    /**
     * Show one venue
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request, $id)
    {
        $venue = \App\Venue::find($id);
        if ( is_null($venue) )
        {
            return redirect()->route('venues')->with('error','venue not found');
        }

        return view('venue.show', [ "venue" => $venue ]);
    }

    public function save(Request $request, $id)
    {
        $info = $request->all();
        $venue = \App\Venue::find($id);
        if(is_null($venue))
        {
            return redirect()->route('venues')->with('error','venue not found');
        }
        $venue->name = $info['name'];
        $venue->address = $info['address'];
        $venue->courts = $info['courts'];
        $venue->save();
        return redirect()->route('venues');
    }

    /**
     * Restore a previously soft deleted venue
     */
    public function restore(Request $request,$id)
    {
        $venue = \App\Venue::onlyTrashed()->find($id);
        if(is_null($venue))
        {
            return redirect()->route('venues')->with('error','venue not found');
        }
        $venue->restore();
        return redirect()->route('venues')->with("showDeleted",$request->input('showDeleted'));
    }

    /**
     * Soft delete a venue
     *
     * @return misc
     */
    public function destroy(Request $request, $id)
    {
        $venue = \App\Venue::find($id);
        if(is_null($venue))
        {
            return redirect()->route('venues')->with('error','venue not found');
        }
        $venue->delete();
        return redirect()->route('venues')->with("showDeleted",$request->input('showDeleted'));
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

        $venue->save();

        return redirect()->route('venues')->with('message','venue created successsfully');
    }
}
