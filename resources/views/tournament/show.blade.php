@extends('layouts.app')

@section('header_scripts')
    @parent
@endsection

@section('content')
<div class="container justify-content-center">
    <form action="{{route('tournaments')}}/{{$tournament->id}}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group row">
            <label for="title" class="col-form-label">{{ __('Title') }}</label>
            <div class="col">
                <input type="text" class="form-control" name="title" id="title" placeholder="{{ __('Title') }}" value="{{ $tournament->title }}"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="datefrom" class="col-form-label">{{ __('Start date') }}</label>
            <div class="col input-group date">
                <input type="text" class="form-control datepicker" id="datefrom" name="datefrom" value="{{$tournament->datefrom}}"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="dateto" class="col-form-label">{{ __('End date') }}</label>
            <div class="col">
                <input type="text" class="form-control datepicker" id="dateto" name="dateto" value="{{$tournament->dateto}}"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="venue" class="col-form-label">{{ __('Venue') }}</label>
            <div class="col">
                <select id="venue" name="venue" class="form-control">
                    @foreach($venues as $venue)
                        <option value="{{$venue->id}}"
                            @if($tournament->venue_id == $venue->id)
                                selected
                            @endif
                            >{{$venue->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col">
                <input type="reset" class="btn" value="{{ __('Reset') }}"/>
            </div>
            <div class="col">
                <a href="{{route('tournaments')}}" class="btn">{{ __('Cancel') }}</a>
            </div>
            <div class="col">
                <input type="submit" class="btn" value="{{ __('Save') }}"/>
            </div>
        </div>
    </form>
</div>
@endsection
