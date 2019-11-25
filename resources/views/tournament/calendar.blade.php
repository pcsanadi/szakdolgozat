@extends('layouts.app')

@section('header_scripts')
    @parent
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 check -->
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 times -->
@endsection

@section('content')
<p class="yjrb29-page-title-bottom-padding">
    @if($filtered)
        {{ __('My applications') }}
    @else
        {{ __('Tournament calendar') }}
    @endif
</p>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-1">
            <a href="#" onclick="document.getElementById('prev_form').submit()">prev</a>
            <form method="POST" id="prev_form"
                @if($filtered)
                    action="{{ route('calendar') }}/{{ $user->id }}"
                @else
                    action="{{ route('calendar') }}"
                @endif
            >
                @csrf
                <input type="hidden" name="season" value="{{ intval($season) - 1 }}"/>
            </form>
        </div>
        <div class="col-1">{{ $season }}</div>
        <div class="col-1">
            <a href="#" onclick="document.getElementById('next_form').submit()">next</a>
            <form method="POST" id="next_form"
                @if($filtered)
                    action="{{ route('calendar') }}/{{ $user->id }}"
                @else
                    action="{{ route('calendar') }}"
                @endif
            >
                @csrf
                <input type="hidden" name="season" value="{{ intval($season) + 1 }}"/>
            </form>
        </div>
    </div>
    @if(empty($tournaments))
    @else
        <div class="yjrb29-top-row">
            <div class="col-2 yjrb29-table-header">{{ __('Date') }}</div>
            <div class="col-3 yjrb29-table-header">{{ __('Title') }}</div>
            <div class="col-2 yjrb29-table-header">{{ __('Location') }}</div>
            <div class="col-1 yjrb29-table-header">{{ __('Requested umpires') }}</div>
            <div class="col-1 yjrb29-table-header">{{ __('Umpire applications') }}</div>
            @if($user->possible_referee)
                <div class="col yjrb29-table-header">D</div>
            @endif
            @if($user->possible_umpire)
                <div class="col yjrb29-table-header">Jv</div>
            @endif
        </div>
        @foreach($tournaments as $tournament)
            <div class="yjrb29-table-row">
                <div class="col-2 yjrb29-table-cell">{{ $tournament->date }}</div>
                <div class="col-3 yjrb29-table-cell">{{ $tournament->title }}</div>
                <div class="col-2 yjrb29-table-cell text-center"
                    title="
{{ $tournament->venue->name }}
({{$tournament->venue->address}})">
                    {{ $tournament->venue->short_name }}
                </div>
                <div class="col-1 yjrb29-table-cell text-center">{{ $tournament->requested_umpires }}</div>
                <div class="col-1 yjrb29-table-cell text-center"
                    @if($user->admin)
                        title="
@foreach($tournament->umpireApplications as $application)
{{$application->user->name}}
@endforeach
                        "
                    @endif
                >{{ $tournament->umpireApplications->count() }}
                </div>
                @if($user->possible_referee)
                    <div class="col yjrb29-table-cell text-center">
                        @if(!$tournament->past)
                            @if($tournament->appliedAsReferee)
                                @if($tournament->refereeApplicationProcessed)
                                    @if($tournament->refereeApplicationApproved)
                                        <span class="fas fa-check yjrb29-big-green"></span>
                                    @else
                                        <span class="fas fa-times yjrb29-big-red"></span>
                                    @endif
                                @else
                                    <span class="fas fa-check yjrb29-big-green"></span>
                                    <a href="#"
                                        onclick="event.preventDefault();document.getElementById('delete_referee_{{$tournament->id}}').submit();">
                                        <span class="fas fa-times yjrb29-small-red" title="{{ __('Revoke') }}"></span>
                                    </a>
                                    <form action="{{route('referee',$tournament->id)}}" method="POST" id="delete_referee_{{$tournament->id}}">
                                        @method('DELETE')
                                        @csrf
                                        <input type="hidden" name="filtered" value="{{$filtered}}"/>
                                    </form>
                                @endif
                            @elseif(!$filtered)
                                <span class="fas fa-times yjrb29-big-red"></span>
                                <a href="#"
                                    onclick="event.preventDefault();document.getElementById('apply_referee_{{$tournament->id}}').submit();">
                                    <span class="fas fa-check yjrb29-small-green" title="{{ __('Apply') }}"></span>
                                </a>
                                <form action="{{route('referee',$tournament->id)}}" method="POST" id="apply_referee_{{$tournament->id}}">
                                    @method('PUT')
                                    @csrf
                                </form>
                            @endif
                        @endif
                    </div>
                @endif
                @if($user->possible_umpire)
                    <div class="col yjrb29-table-cell text-center">
                        @if(!$tournament->past)
                            @if($tournament->appliedAsUmpire)
                                @if($tournament->umpireApplicationProcessed)
                                    @if($tournament->umpireApplicationApproved)
                                        <span class="fas fa-check yjrb29-big-green"></span>
                                    @else
                                        <span class="fas fa-times yjrb29-big-red"></span>
                                    @endif
                                @else
                                    <span class="fas fa-check yjrb29-big-green"></span>
                                    <a href="#"
                                        onclick="event.preventDefault();document.getElementById('delete_umpire_{{$tournament->id}}').submit();">
                                        <span class="fas fa-times yjrb29-small-red" title="{{ __('Revoke') }}"></span>
                                    </a>
                                    <form action="{{route('umpire',$tournament->id)}}" method="POST" id="delete_umpire_{{$tournament->id}}">
                                        @method('DELETE')
                                        @csrf
                                        <input type="hidden" name="filtered" value="{{$filtered}}"/>
                                    </form>
                                @endif
                            @elseif(!$filtered)
                                <span class="fas fa-times yjrb29-big-red"></span>
                                <a href="#"
                                    onclick="event.preventDefault();document.getElementById('apply_umpire_{{$tournament->id}}').submit();">
                                    <span class="fas fa-check yjrb29-small-green" title="{{ __('Apply') }}"></span>
                                </a>
                                <form action="{{route('umpire',$tournament->id)}}" method="POST" id="apply_umpire_{{$tournament->id}}">
                                    @method('PUT')
                                    @csrf
                                </form>
                            @endif
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    @endif
</div>
@endsection