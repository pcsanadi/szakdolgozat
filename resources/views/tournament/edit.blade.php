@extends('layouts.app')

@section('header_scripts')
    @parent
@endsection

@section('content')
<div class="yjrb29-page-title-bottom-padding">
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
        action="{{route('tournaments.show',$tournament->id)}}">
        @method('PUT')
    @else
        action="{{route('tournaments.index')}}">
    @endif
    @csrf
    <div class="form-group row">
        <div class="yjrb29-form-label">
            <label for="title">{{ __('Title') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input type="text" class="form-control @error('title') is-invalid @enderror"
            autocomplete="off" name="title" id="title" required
                value="{{ old('title') ? old('title') : ( isset($tournament) ? $tournament->title : '') }}"
            />
            @error("title")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-label">
            <label for="datefrom">{{ __('Start date') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input type="text" class="form-control datepicker @error('datefrom') is-invalid @enderror"
                autocomplete="off" id="datefrom" name="datefrom" required
                value="{{ old('datefrom') ? old('datefrom') : ( isset($tournament) ? $tournament->datefrom->format('Y-m-d') : '') }}"
            />
            @error("datefrom")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-label">
            <label for="dateto">{{ __('End date') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input type="text" class="form-control datepicker @error('dateto') is-invalid @enderror"
                autocomplete="off" id="dateto" name="dateto" required
                value="{{ old('dateto') ? old('dateto') : ( isset($tournament) ? $tournament->dateto->format('Y-m-d') : '') }}"
            />
            @error("dateto")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-label">
            <label for="venue">{{ __('Venue') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <select id="venue" name="venue" class="form-control @error('venue') is-invalid @enderror" required>
                <option value="" selected disabled>{{ __('Choose') }}...</option>
                @foreach($venues as $venue)
                    <option value="{{$venue->id}}"
                        @if( old('venue') and $venue->id == old('venue') )
                            selected
                        @elseif(isset($tournament) and $venue->id == $tournament->venue_id)
                            selected
                        @endif
                    >{{$venue->name}}</option>
                @endforeach
            </select>
            @error('venue')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-label">
            <label for="requested_umpires">{{ __('Requested umpires') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input id="requested_umpires" class="form-control @error('requested_umpires') is-invalid @enderror"
                autocomplete="off" name="requested_umpires" type="number" required
                value="{{ old('requested_umpires') ? old('requested_umpires') : ( isset($tournament) ? $tournament->requested_umpires : '') }}"
            />
            @error("requested_umpires")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="yjrb29-buttons-row">
        <div class="yjrb29-show-page-button yjrb29-form-first-button">
            @if(isset($tournament))
                <input type="reset" class="yjrb29-btn-blue" value="{{ __('Reset') }}"/>
            @endif
        </div>
        <div class="yjrb29-show-page-button">
            <a href="{{route('tournaments.index')}}" class="yjrb29-btn-red">{{ __('Cancel') }}</a>
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
