<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
     * Show the list of all users.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = \App\User::withTrashed()->with(["umpireLevel","refereeLevel"])->get()->sortBy('name');
        if( is_null($users) )
        {
            abort(500,"Internal Server Error");
        }

        return view("user.list", [ "users" => $users ])->with("showDeleted",session("showDeleted","false"));
    }

    /**
     * Show one user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Request $request, $id)
    {
        $user = \App\User::find($id);
        if ( is_null($user) )
        {
            return redirect()->route("users")->with("error","user not found");
        }

        return view('user.edit', [ "user" => $user ]);
    }

    /**
     * Update a user.
     *
     * @return misc
     */
    public function save(Request $request, $id)
    {
        $info = $request->all();
        $user = \App\User::find($id);
        if( is_null($user) )
        {
            return redirect()->route("users")->with("error","user not found");
        }
        if( !array_key_exists( "name", $info )
            or !array_key_exists( "email", $info )
            or !array_key_exists( "ulevel", $info )
            or !array_key_exists( "rlevel", $info ) )
        {
            return redirect()->route("users")->with("error","could not save user");
        }
        $user->name = $info["name"];
        $user->email = $info["email"];
        $user->umpire_level = $info["ulevel"];
        $user->referee_level = $info["rlevel"];
        $user->admin = array_key_exists( "admin", $info );
        $user->password = Hash::make("5555");
        if( $user->save() )
        {
            // TODO send out initial password
            return redirect()->route("users")->with("message","user saved successfully");
        }
        else
        {
            return redirect()->route("users")->with("error","could not save user");
        }
    }

    /**
     * Restore a previously soft deleted user.
     *
     * @return misc
     */
    public function restore(Request $request, $id)
    {
        $user = \App\User::onlyTrashed()->find($id);
        if( is_null($user) )
        {
            return redirect()->route("users")->with("error","user not found");
        }
        $user->restore();
        return redirect()->route("users")->with("showDeleted",$request->input("showDeleted"));
    }

    /**
     * Soft delete a user
     *
     * @return misc
     */
    public function destroy(Request $request, $id)
    {
        $user = \App\User::find($id);
        if( is_null($user) )
        {
            return redirect()->route("users")->with("error","user not found");
        }
        $user->delete();
        return redirect()->route("users")->with("showDeleted",$request->input('showDeleted'));
    }

    /**
     * Show user.create view.
     *
     * @return misc
     */
    public function create()
    {
        $umpire_levels = \App\UmpireLevel::all()->sortBy('id');
        $referee_levels = \App\RefereeLevel::all()->sortBy('id');
        if( is_null($umpire_levels) or is_null($referee_levels) )
        {
            abort(500,"Internal Server Error");
        }
        return view("user.edit", [ "umpire_levels" => $umpire_levels,
                                    "referee_levels" => $referee_levels]);
    }

    /**
     * Store a new user
     *
     * @return misc
     */
    public function store(Request $request)
    {
        $info = $request->all();
        if( 0 != \App\User::where("email",$info["email"])->count() )
        {
            return redirect()->route("users")->with("error","user with this email already exists");
        }
        if( !array_key_exists("name",$info)
            or !array_key_exists("email",$info)
            or !array_key_exists("ulevel",$info)
            or !array_key_exists("rlevel",$info) )
        {
            return redirect()->route("users")->with("error","could not save user");
        }
        $user = new \App\User;
        $user->name = $info["name"];
        $user->email = $info["email"];
        $user->umpire_level = $info["ulevel"];
        $user->referee_level = $info["rlevel"];
        $user->admin = array_key_exists("admin", $info);

        return $user->save()
            ? redirect()->route("users")->with("message","user created successsfully")
            : redirect()->route("users")->with("error","could not save user");
    }
}
