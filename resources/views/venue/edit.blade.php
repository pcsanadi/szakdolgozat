@extends('layouts.app')

@section('header_scripts')
    @parent
@endsection

@section('content')
<div class="yjrb29-page-title-bottom-padding">
    <div class="col-auto">
        @if(isset($venue))
            {{ __('Edit venue') }}
        @else
            {{ __('New venue') }}
        @endif
    </div>
</div>
<form method="POST"
    @if(isset($venue))
        action="{{route('venues.show',$venue->id)}}">
        @method('PUT')
    @else
        action="{{route('venues.index')}}">
    @endif
    @csrf
    <div class="form-group row">
        <div class="yjrb29-form-label">
            <label for="name">{{ __('Name') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                autocomplete="off" name="name" id="name" required
                value="{{ old('name') ? old('name') : ( isset($venue) ? $venue->name : '') }}"
            />
            @error("name")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-label">
            <label for="short_name">{{ __('Short name') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input type="text" class="form-control @error('short_name') is-invalid @enderror"
                autocomplete="off" name="short_name" id="short_name" required
                value="{{ old('short_name') ? old('short_name') : ( isset($venue) ? $venue->short_name : '') }}"
            />
            @error("short_name")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-label">
            <label for="address">{{ __('Address') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input type="text" class="form-control @error('address') is-invalid @enderror"
                autocomplete="off" name="address" id="address" required
                value="{{ old('address') ? old('address') : ( isset($venue) ? $venue->address : '') }}"
            />
            @error("address")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-label">
            <label for="courts">{{ __('# of courts') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input type="number" class="form-control @error('courts') is-invalid @enderror"
                autocomplete="off" name="courts" id="courts" required
                value="{{ old('courts') ? old('courts') : ( isset($venue) ? $venue->courts : '') }}"
            />
            @error("courts")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="yjrb29-buttons-row">
        <div class="yjrb29-show-page-button yjrb29-form-first-button">
            @if(isset($venue))
                <input type="reset" class="yjrb29-btn-blue" value="{{ __('Reset') }}"/>
            @endif
        </div>
        <div class="yjrb29-show-page-button">
            <a href="{{route('venues.index')}}" class="yjrb29-btn-red">{{ __('Cancel') }}</a>
        </div>
        <div class="yjrb29-show-page-button">
            <input type="submit" class="yjrb29-btn-green"
                @if(isset($venue))
                    value="{{ __('Save') }}"
                @else
                    value="{{ __('Create') }}"
                @endif
            />
        </div>
    </div>
</form>
@endsection
