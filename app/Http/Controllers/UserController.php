<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\UmpireLevel;
use App\RefereeLevel;

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
        $users = User::withTrashed()->get()->sortBy('name');
        abort_if( is_null($users),500,"Internal Server Error");

        return view("user.list", [ "users" => $users ])->with("showDeleted",session("showDeleted","false"));
    }

    /**
     * Show one user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $user = User::find($id);
        if ( is_null($user) )
        {
            return redirect()->route("users.index")->with("error","user not found");
        }
        $umpire_levels = UmpireLevel::all();
        $referee_levels = RefereeLevel::all();

        return view("user.edit", [  "user" => $user,
                                    "umpire_levels" => $umpire_levels,
                                    "referee_levels" => $referee_levels ]);
    }

    /**
     * Update a user.
     *
     * @return misc
     */
    public function update(Request $request, $id)
    {
        $info = $request->all();
        $user = User::find($id);
        if( is_null($user) )
        {
            return redirect()->route("users")->with("error","user not found");
        }
        if( !array_key_exists( "name", $info )
            or !array_key_exists( "email", $info )
            or !array_key_exists( "ulevel", $info )
            or !array_key_exists( "rlevel", $info ) )
        {
            return redirect()->route("users.index")->with("error","user not found");
        }
        $user->name = $info["name"];
        $user->email = $info["email"];
        $user->umpire_level = $info["ulevel"];
        $user->referee_level = $info["rlevel"];
        $user->admin = array_key_exists( "admin", $info );
        $user->password = Hash::make("5555");
        {
            // TODO send out initial password
            return redirect()->route("users")->with("message","user saved successfully");
        }
        else
        {
            return redirect()->route("users")->with("error","could not save user");
        }
        return $user->save()
            ? redirect()->route("users.index")->with("message","user saved successfully")
            : redirect()->route("users.index")->with("error","could not save user");
    }

    /**
     * Restore a previously soft deleted user.
     *
     * @return misc
     */
    public function restore(Request $request, $id)
    {
        $user = User::onlyTrashed()->find($id);
        if( is_null($user) )
        {
            return redirect()->route("users.index")->with("error","user not found");
        }
        $user->restore();
        return redirect()->route("users.index")->with("showDeleted",$request->showDeleted);
    }

    /**
     * Soft delete a user
     *
     * @return misc
     */
    public function destroy(Request $request, $id)
    {
        return User::destroy($id)
            ? redirect()->route("users.index")->with("showDeleted",$request->showDeleted)
            : redirect()->route("users.index")->with(["showDeleted" => $request->showDeleted, "error" => "could not delete user"]);
    }

    /**
     * Show user.create view.
     *
     * @return misc
     */
    public function create()
    {
        $umpire_levels = UmpireLevel::all()->sortBy("id");
        $referee_levels = RefereeLevel::all()->sortBy("id");
        abort_if( is_null($umpire_levels) or is_null($referee_levels),500,"Internal Server Error");
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
        {
            return redirect()->route("users.index")->with("error","could not save user");
        }
        if( 0 != User::where("email",$request->email)->count() )
        if( !array_key_exists("name",$info)
            or !array_key_exists("email",$info)
            or !array_key_exists("ulevel",$info)
            or !array_key_exists("rlevel",$info) )
        {
            return redirect()->route("users.index")->with("error","user with this email already exists");
        }
        $user = new User;
        $user->name = $info["name"];
        $user->email = $info["email"];
        $user->umpire_level = $info["ulevel"];
        $user->referee_level = $info["rlevel"];
        $user->admin = array_key_exists("admin", $info);

        return $user->save()
            ? redirect()->route("users.index")->with("message","user created successsfully")
            : redirect()->route("users.index")->with("error","could not create user");
    }
}
