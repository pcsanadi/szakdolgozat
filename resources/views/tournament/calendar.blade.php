@extends('layouts.app')

@section('content')
<div class="yjrb29-page-title-bottom-padding">
    <div class="col-md-auto">
        @if($filtered)
            {{ __('My applications') }}
        @else
            {{ __('Tournament calendar') }}
        @endif
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-1 text-center">
        <a href="#" onclick="document.getElementById('prev_form').submit()">{{ __('prev') }}</a>
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
    <div class="col-md-2 text-center">{{ $season }}-{{ intval($season) + 1 }}</div>
    <div class="col-md-1 text-center">
        <a href="#" onclick="document.getElementById('next_form').submit()">{{ __('next') }}</a>
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
    <div class="yjrb29-empty-list justify-content-center row text-center pt-md-4" style="font-size: 120%;">
        <div class="col">
            {{ __('No tournament to show') }}
        </div>
    </div>
@else
    <div class="yjrb29-top-row">
        <div class="yjrb29-table-header-2">{{ __('Date') }}</div>
        <div class="yjrb29-table-header-3">{{ __('Title') }}</div>
        <div class="yjrb29-table-header-2">{{ __('Location') }}</div>
        <div class="yjrb29-table-header-1">{{ __('Requested umpires') }}</div>
        <div class="yjrb29-table-header-1">{{ __('Umpire applications') }}</div>
        @if($user->possible_referee)
            <div class="yjrb29-table-header">{{ __('Referee') }}</div>
        @endif
        @if($user->possible_umpire)
            <div class="yjrb29-table-header">{{ __('Umpire') }}</div>
        @endif
    </div>
    @foreach($tournaments as $tournament)
        <div class="yjrb29-table-row">
            <div class="yjrb29-table-cell-2">{{ $tournament->date }}</div>
            <div class="yjrb29-table-cell-3">{{ $tournament->title }}</div>
            <div class="yjrb29-table-cell-2 text-center"
                title="
{{ $tournament->venue->name }}
({{$tournament->venue->address}})">
                {{ $tournament->venue->short_name }}
            </div>
            <div class="yjrb29-table-cell-1 text-center">{{ $tournament->requested_umpires }}</div>
            <div class="yjrb29-table-cell-1 text-center"
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
                <div class="yjrb29-table-cell text-center">
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
                <div class="yjrb29-table-cell text-center">
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
@endsection