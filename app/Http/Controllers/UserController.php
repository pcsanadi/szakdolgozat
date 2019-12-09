<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
        $this->validator($request,false)->validate();
        $user = User::find($id);
        if( is_null($user) )
        {
            return redirect()->route("users.index")->with("error","user not found");
        }
        if( !$request->has(["name","email","ulevel","rlevel"]) )
        {
            return redirect()->route("users.index")->with("error","could not save user");
        }
        $user->name = $request->name;
        $user->email = $request->email;
        if( $request->has('password') )
        {
            $user->password = Hash::make($request->password);
        }
        $user->umpire_level = $request->ulevel;
        $user->referee_level = $request->rlevel;
        $user->admin = $request->has("admin");
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
        $this->validator($request,true)->validate();
        abort_unless($request->has(["name","email","password","ulevel","rlevel"]),500,"Internal Server Error");
        if( 0 != User::withTrashed()->where("email",$request->email)->count() )
        {
            return redirect()->route("users.index")->with("error","user with this email already exists");
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->umpire_level = $request->ulevel;
        $user->referee_level = $request->rlevel;
        $user->admin = $request->has("admin");

        return $user->save()
            ? redirect()->route("users.index")->with("message","user created successfully")
            : redirect()->route("users.index")->with("error","could not create user");
    }

    /**
     * Create a validator and validate the request
     *
     * @param Illuminate\Http\Request
     * @param boolean true if we try to create a new user
     *
     */
    private function validator(Request $request, $create)
    {
        $rules = [
            "name" => "required",
            "email" => ( $create ? "bail|required|email|unique:users" : "bail|required|email" ),
            "password" => ( $create ? "required" : "" ),
            "ulevel" => "required",
            "rlevel" => "required",
        ];
        return Validator::make( $request->all(), $rules );
    }
}
