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
        $this->middleware("admin");
    }

    /**
     * Show the list of all venues.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $venues = \App\Venue::withTrashed()->get()->sortBy("name");
        if( is_null($venues) )
        {
            abort(500,"Internal Server Error");
        }
        return view("venue.list", [ "venues" => $venues ])->with("showDeleted",session("showDeleted","false"));
    }

    /**
     * Show one venue
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request, $id)
    {
        $venue = \App\Venue::find($id);
        return is_null($venue)
            ? redirect()->route("venues")->with("error", "venue not found")
            : view("venue.edit", ["venue" => $venue]);
    }

    /**
     * Update a venue
     */
    public function save(Request $request, $id)
    {
        $info = $request->all();
        $venue = \App\Venue::find($id);
        if( is_null($venue) )
        {
            return redirect()->route("venues")->with("error","venue not found");
        }
        if( !array_key_exists("name",$info)
            or !array_key_exists("short_name",$info)
            or !array_key_exists("address",$info)
            or !array_key_exists("courts",$info) )
        {
            abort(500,"Internal Server Error");
        }
        $venue->name = $info["name"];
        $venue->short_name = $info["short_name"];
        $venue->address = $info["address"];
        $venue->courts = intval($info["courts"]);
        return $venue->save()
            ? redirect()->route("venues")->with("message","venue saved successfully")
            : redirect()->route("venues")->with("error","could not save venue");
    }

    /**
     * Restore a previously soft deleted venue
     */
    public function restore(Request $request,$id)
    {
        $venue = \App\Venue::onlyTrashed()->find($id);
        if( is_null($venue) )
        {
            return redirect()->route("venues")->with("error","venue not found");
        }
        $venue->restore();
        return redirect()->route("venues")->with("showDeleted",$request->input("showDeleted"));
    }

    /**
     * Soft delete a venue
     *
     * @return misc
     */
    public function destroy(Request $request, $id)
    {
        return \App\Venue::destroy($id)
            ? redirect()->route("venues")->with("showDeleted",$request->input("showDeleted"))
            : redirect()->route("venues")->with(["showDeleted" => $request->input("showDeleted"), "error" => "could not delete venue"]);
    }

    /**
     * Show venue.create view
     *
     * @return misc
     */
    public function create()
    {
        return view("venue.edit");
    }

    /**
     * Store a new venue
     *
     * @return misc
     */
    public function store(Request $request)
    {
        $info = $request->all();
        if( 0 != \App\Venue::where("name",$info["name"])
                    ->orWhere("short_name",$info["short_name"])
                    ->orWhere("address",$info["address"])
                    ->count() )
        {
            return redirect()->route("venues")->with("error","a venue with this name, short name or address already exists");
        }
        if( !array_key_exists("name",$info)
            or !array_key_exists("short_name",$info)
            or !array_key_exists("address",$info)
            or !array_key_exists("courts",$info) )
        {
            abort(500,"Internal Server Error");
        }
        $venue = new \App\Venue;
        $venue->name = $info["name"];
        $venue->short_name = $info["short_name"];
        $venue->address = $info["address"];
        $venue->courts = intval($info["courts"]);
        return $venue->save()
            ? redirect()->route("venues")->with("message","venue created successsfully")
            : redirect()->route("venues")->with("error","could not create venue");
    }
}
