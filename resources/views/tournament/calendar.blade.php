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
                    @if($tournament->appliedAsReferee)
                        <span class="fas fa-check text-success yjrb29-big"></span>
                        <a href="#"
                            onclick="event.preventDefault();document.getElementById('delete_referee_{{$tournament->id}}').submit();">
                            <span class="fas fa-times yjrb29-small text-danger" title="{{ __('Revoke') }}"></span>
                        </a>
                        <form action="{{route('referee',$tournament->id)}}" method="POST" id="delete_referee_{{$tournament->id}}">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="filtered" value="{{$filtered}}"/>
                        </form>
                    @elseif(!$filtered)
                        <span class="fas fa-times yjrb29-big text-danger"></span>
                        <a href="#"
                            onclick="event.preventDefault();document.getElementById('apply_referee_{{$tournament->id}}').submit();">
                            <span class="fas fa-check yjrb29-small text-success" title="{{ __('Apply') }}"></span>
                        </a>
                        <form action="{{route('referee',$tournament->id)}}" method="POST" id="apply_referee_{{$tournament->id}}">
                            @method('PUT')
                            @csrf
                        </form>
                    @endif
                </div>
            @endif
            @if($user->possible_umpire)
                <div class="col yjrb29-table-cell text-center">
                    @if($tournament->appliedAsUmpire)
                        <span class="fas fa-check text-success yjrb29-big"></span>
                        <a href="#"
                            onclick="event.preventDefault();document.getElementById('delete_umpire_{{$tournament->id}}').submit();">
                            <span class="fas fa-times yjrb29-small text-danger" title="{{ __('Revoke') }}"></span>
                        </a>
                        <form action="{{route('umpire',$tournament->id)}}" method="POST" id="delete_umpire_{{$tournament->id}}">
                            @method('DELETE')
                            @csrf
                            <input type="hidden" name="filtered" value="{{$filtered}}"/>
                        </form>
                    @elseif(!$filtered)
                        <span class="fas fa-times yjrb29-big text-danger"></span>
                        <a href="#"
                            onclick="event.preventDefault();document.getElementById('apply_umpire_{{$tournament->id}}').submit();">
                            <span class="fas fa-check yjrb29-small text-success" title="{{ __('Apply') }}"></span>
                        </a>
                        <form action="{{route('umpire',$tournament->id)}}" method="POST" id="apply_umpire_{{$tournament->id}}">
                            @method('PUT')
                            @csrf
                        </form>
                    @endif
                </div>
            @endif
        </div>
    @endforeach
</div>
@endsection