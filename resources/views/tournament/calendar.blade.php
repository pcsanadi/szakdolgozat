@extends('layouts.app')

@section('header_scripts')
    @parent
@endsection

@section('content')
admin: {{ $user->admin }}<br/>
ref: {{ $user->possible_referee }}<br/>
ump: {{ $user->possible_umpire }}<br/>
<div class="container justify-content-center">
    <div class="row">
        <div class="col">{{ __('Date') }}</div>
        <div class="col">{{ __('Title') }}</div>
        <div class="col">{{ __('Location') }}</div>
        <div class="col">{{ __('Requested umpires') }}</div>
        <div class="col">{{ __('Umpire applications') }}</div>
        @if($user->admin)
            <div class="col">{{ __('Referee(s)') }}</div>
            <div class="col">{{ __('Umpires') }}</div>
        @endif
        @if($user->possible_referee)
            <div class="col">&nbsp;</div>
        @endif
        @if($user->possible_umpire)
            <div class="col">&nbsp;</div>
        @endif
    </div>
    @foreach($tournaments as $tournament)
        <div class="row">
            <div class="col">{{ $tournament->date }}</div>
            <div class="col">{{ $tournament->title }}</div>
            <div class="col">
                {{ $tournament->venue->name }}<br/>
                ({{ $tournament->venue->address }})
            </div>
            <div class="col">{{ $tournament->requested_umpires }}</div>
            <div class="col">{{-- $tournament->umpire_applications->count() --}}</div>
            @if($user->admin)
                <div class="col">
                    {{--@foreach($tournament->referee_applications as $application)
                        {{ $application->name }}
                        @if(!$loop->last)<br/>@endif
                    @endforeach--}}
                </div>
                <div class="col">
                    {{--@foreach($tournament->umpire_applications as $application)
                        {{ $application->name }}
                        @if(!$loop->last)<br/>@endif
                    @endforeach--}}
                </div>
            @endif
        @if($user->possible_referee)
            <div class="col">
                apply for referee
            </div>
        @endif
        @if($user->possible_umpire)
            <div class="col">
                apply for umpire
            </div>
        @endif
        </div>
    @endforeach
</div>
@endsection