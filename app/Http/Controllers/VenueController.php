<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Venue;

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
        $venues = Venue::withTrashed()->get()->sortBy("name");
        abort_if(is_null($venues),500,"Internal Server Error");
        return view("venue.list", [ "venues" => $venues ])->with("showDeleted",session("showDeleted","false"));
    }

    /**
     * Show one venue
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $venue = Venue::find($id);
        return is_null($venue)
            ? redirect()->route("venues.index")->with("error", "venue not found")
            : view("venue.edit", ["venue" => $venue]);
    }

    /**
     * Update a venue
     */
    public function update(Request $request, $id)
    {
        $this->validator($request,false)->validate();
        $venue = Venue::find($id);
        if( is_null($venue) )
        {
            return redirect()->route("venues.index")->with("error","venue not found");
        }
        abort_unless($request->has(["name","short_name","address","courts"]),500,"Internal Server Error");
        $venue->name = $request->name;
        $venue->short_name = $request->short_name;
        $venue->address = $request->address;
        $venue->courts = intval($request->courts);
        return $venue->save()
            ? redirect()->route("venues.index")->with("message","venue saved successfully")
            : redirect()->route("venues.index")->with("error","could not save venue");
    }

    /**
     * Restore a previously soft deleted venue
     */
    public function restore(Request $request,$id)
    {
        $venue = Venue::onlyTrashed()->find($id);
        if( is_null($venue) )
        {
            return redirect()->route("venues.index")->with("error","venue not found");
        }
        $venue->restore();
        return redirect()->route("venues.index")->with("showDeleted",$request->showDeleted);
    }

    /**
     * Soft delete a venue
     *
     * @return misc
     */
    public function destroy(Request $request, $id)
    {
        return Venue::destroy($id)
            ? redirect()->route("venues.index")->with("showDeleted",$request->showDeleted)
            : redirect()->route("venues.index")->with(["showDeleted" => $request->showDeleted, "error" => "could not delete venue"]);
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
        $this->validator($request,true)->validate();
        abort_unless($request->has(["name","short_name","address","courts"]),500,"Internal Server Error");
        $venue = new Venue;
        $venue->name = $request->name;
        $venue->short_name = $request->short_name;
        $venue->address = $request->address;
        $venue->courts = intval($request->courts);
        return $venue->save()
            ? redirect()->route("venues.index")->with("message","venue created successsfully")
            : redirect()->route("venues.index")->with("error","could not create venue");
    }

    /**
     * Create a validator and validate the request
     *
     * @param Illuminate\Http\Request
     * @param boolean true if we try to create a new venue
     *
     */
    private function validator(Request $request, $create)
    {
        $rules = [
            "name" => ( $create ? "required|unique:venues" : "required" ),
            "short_name" => ( $create ? "required|unique:venues" : "required" ),
            "address" => ( $create ? "required|unique:venues" : "required" ),
            "courts" => "numeric",
        ];
        return Validator::make( $request->all(), $rules );
    }
}
