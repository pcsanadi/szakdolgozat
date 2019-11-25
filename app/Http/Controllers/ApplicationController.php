<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Apply to a tournament as an umpire
     */
    public function addUmpire($id)
    {
        $userId = \Auth::user()->id;
        if( \App\UmpireApplication::where(['tournament_id'=>$id,'umpire_id'=>$userId])->count() > 0 )
        {
            return redirect()->route('calendar')->with('error','application already in database');
        }
        $application = new \App\UmpireApplication;
        $application->umpire_id = $userId;
        $application->tournament_id = $id;
        $application->approved = null;
        $application->save();
        return redirect()->route('calendar');
    }

    /**
     * Remove an umpire application for a tournament
     */
    public function removeUmpire(Request $request, $id)
    {
        $filtered = $request->input('filtered');
        $userId = \Auth::user()->id;
        $application = \App\UmpireApplication::where(['tournament_id'=>$id,'umpire_id'=>$userId])->first();
        if( is_null($application) )
        {
            return $filtered
                ? redirect()->route('calendar',$userId)->with('error','application not found')
                : redirect()->route('calendar')->with('error','application not found');
        }
        $application->delete();
        return $filtered ? redirect()->route('calendar',$userId) : redirect()->route('calendar');
    }

    /**
     * Apply to a tournament as a referee
     */
    public function addReferee($id)
    {
        $userId = \Auth::user()->id;
        if( \App\RefereeApplication::where(['tournament_id'=>$id,'referee_id'=>$userId])->count() > 0 )
        {
            return redirect()->route('calendar')->with('error','application already in database');
        }
        $application = new \App\RefereeApplication;
        $application->referee_id = $userId;
        $application->tournament_id = $id;
        $application->approved = null;
        $application->save();
        return redirect()->route('calendar');
    }

    /**
     * Remove a referee application for a tournament
     */
    public function removeReferee(Request $request, $id)
    {
        $filtered = $request->input('filtered');
        $userId = \Auth::user()->id;
        $application = \App\RefereeApplication::where(['tournament_id'=>$id,'referee_id'=>$userId])->first();
        if( is_null($application) )
        {
            return $filtered
                ? redirect()->route('calendar',$userId)->with('error','application not found')
                : redirect()->route('calendar')->with('error','application not found');
        }
        $application->delete();
        return $filtered ? redirect()->route('calendar',$userId) : redirect()->route('calendar');
    }
}
