<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // tmp

class UserController extends Controller
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
     * Show the list of all users.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = \App\User::withTrashed()
                        ->with(['umpireLevel','refereeLevel'])->get();

        return view('user.list', [ "users" => $users ])->with("showDeleted",session("showDeleted","false"));
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
            return redirect()->route('users')->with('error','user not found');
        }
        $referee_levels = \App\RefereeLevel::all();
        $umpire_levels = \App\UmpireLevel::all();

        return view('user.show', [ "user" => $user,
                                    "umpire_levels" => $umpire_levels,
                                    "referee_levels" => $referee_levels ]);
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
        if(is_null($user))
        {
            return redirect()->route('users')->with('error','user not found');
        }
        $user->name = $info['name'];
        $user->email = $info['email'];
        $user->umpire_level = $info['ulevel'];
        $user->referee_level = $info['rlevel'];
        $user->admin = array_key_exists( 'admin', $info );
        $user->save();
        return redirect()->route('users');
    }

    /**
     * Restore a previously soft deleted user.
     *
     * @return misc
     */
    public function restore(Request $request, $id)
    {
        $user = \App\User::onlyTrashed()->find($id);
        if(is_null($user))
        {
            return redirect()->route('users')->with('error','user not found');
        }
        $user->restore();
        return redirect()->route('users')->with("showDeleted",$request->input('showDeleted'));
    }

    /**
     * Soft delete a user
     *
     * @return misc
     */
    public function destroy(Request $request, $id)
    {
        $user = \App\User::find($id);
        if(is_null($user))
        {
            return redirect()->route('users')->with('error','user not found');
        }
        $user->delete();
        return redirect()->route('users')->with("showDeleted",$request->input('showDeleted'));
    }

    /**
     * Show user.create view.
     *
     * @return misc
     */
    public function create()
    {
        $umpire_levels = \App\UmpireLevel::all();
        $referee_levels = \App\RefereeLevel::all();
        return view('user.create', ["umpire_levels" => $umpire_levels, "referee_levels" => $referee_levels]);
    }

    /**
     * Store a new user
     *
     * @return misc
     */
    public function store(Request $request)
    {
        $info = $request->all();
        if( 0 != \App\User::where('email',$info['email'])->count() )
        {
            return redirect()->route('users')->with('error','user with this email already exists');
        }
        $user = new \App\User;
        $user->name = $info['name'];
        $user->email = $info['email'];
        $user->password = Hash::make($info['email']);
        $user->umpire_level = $info['ulevel'];
        $user->referee_level = $info['rlevel'];
        $user->admin = array_key_exists('admin', $info);

        $user->save();

        return redirect()->route('users')->with('message','user created successsfully');
    }
}
