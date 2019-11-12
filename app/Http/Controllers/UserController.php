<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        return view('user.list', [ "users" => $users ]);
    }

    public function show($id)
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

    public function restore($id)
    {
        $user = \App\User::onlyTrashed()->find($id);
        if(is_null($user))
        {
            return redirect()->route('users')->with('error','user not found');
        }
        $user->restore();
        return redirect()->route('users');
    }

    public function destroy($id)
    {
        $user = \App\User::find($id);
        if(is_null($user))
        {
            return redirect()->route('users')->with('error','user not found');
        }
        $user->delete();
        return redirect()->route('users');
    }
}
