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
        return view('users', [ "users" => $users ]);
    }

    public function show($id)
    {
        $user = \App\User::find($id);
        $referee_levels = \App\RefereeLevel::all();
        $umpire_levels = \App\UmpireLevel::all();
        if ( is_null($user) )
        {
            redirect('users')->with('error','user not found');
        }

        return view('showUser', [ "user" => $user,
                                  "umpire_levels" => $umpire_levels,
                                  "referee_levels" => $referee_levels ]);
    }
}
