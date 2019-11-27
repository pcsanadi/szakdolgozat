@extends('layouts.app')

@section('header_scripts')
    @parent
@endsection

@section('content')
<div class="row justify-content-center yjrb29-page-title-bottom-padding">
    <div class="col-auto">
        @if(isset($tournament))
            {{ __('Edit tournament') }}
        @else
            {{ __('New tournament') }}
        @endif
    </div>
</div>
<form method="POST"
    @if(isset($tournament))
        action="{{route('showTournament',$tournament->id)}}">
        @method('PUT')
    @else
        action="{{route('tournaments')}}">
    @endif
    @csrf
    <div class="form-group row">
        <div class="yjrb29-form-left-spacer"></div>
        <div class="yjrb29-form-label">
            <label for="title">{{ __('Title') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input type="text" class="form-control" name="title" id="title" placeholder="{{ __('Title') }}"
                @if(isset($tournament))
                    value="{{ $tournament->title }}"
                @endif
            />
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-left-spacer"></div>
        <div class="yjrb29-form-label">
            <label for="datefrom">{{ __('Start date') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input type="text" class="form-control datepicker" id="datefrom" name="datefrom"
                @if(isset($tournament))
                    value="{{$tournament->datefrom->format('Y-m-d')}}"
                @endif
            />
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-left-spacer"></div>
        <div class="yjrb29-form-label">
            <label for="dateto">{{ __('End date') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input type="text" class="form-control datepicker" id="dateto" name="dateto"
                @if(isset($tournament))
                    value="{{$tournament->dateto->format('Y-m-d')}}"
                @endif
            />
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-left-spacer"></div>
        <div class="yjrb29-form-label">
            <label for="venue">{{ __('Venue') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <select id="venue" name="venue" class="form-control">
                <option value="" selected disabled>{{ __('Choose') }}...</option>
                @foreach($venues as $venue)
                    <option value="{{$venue->id}}"
                        @if(isset($tournament) and $venue->id == $tournament->venue_id)
                            selected
                        @endif
                    >{{$venue->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-left-spacer"></div>
        <div class="yjrb29-form-label">
            <label for="requested_umpires">{{ __('Requested umpires') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input id="requested_umpires" class="form-control" name="requested_umpires" type="number"
                @if(isset($tournament))
                    value="{{ $tournament->requested_umpires }}"
                @endif
            />
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-left-spacer"></div>
        <div class="yjrb29-show-page-button">
            @if(isset($tournament))
                <input type="reset" class="yjrb29-btn-blue" value="{{ __('Reset') }}"/>
            @endif
        </div>
        <div class="yjrb29-show-page-button">
            <a href="{{route('tournaments')}}" class="yjrb29-btn-red">{{ __('Cancel') }}</a>
        </div>
        <div class="yjrb29-show-page-button">
            <input type="submit" class="yjrb29-btn-green"
                @if(isset($tournament))
                    value="{{ __('Save') }}"
                @else
                    value="{{ __('Create') }}"
                @endif
            />
        </div>
    </div>
</form>
@endsection
