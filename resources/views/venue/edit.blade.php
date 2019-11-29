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
        action="{{route('showVenue',$venue->id)}}">
        @method('PUT')
    @else
        action="{{route('venues')}}">
    @endif
    @csrf
    <div class="form-group row">
        <div class="yjrb29-form-label">
            <label for="name">{{ __('Name') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input type="text" class="form-control" autocomplete="off" name="name" id="name" placeholder="{{ __('Name') }}"
                @if(isset($venue))
                    value="{{ $venue->name }}"
                @endif
            />
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-label">
            <label for="short_name">{{ __('Short name') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input type="text" class="form-control" autocomplete="off" name="short_name" id="short_name" placeholder="{{ __('Short name') }}"
            @if(isset($venue))
                value="{{ $venue->short_name }}"
            @endif
        />
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-label">
            <label for="address">{{ __('Address') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input type="text" class="form-control" autocomplete="off" name="address" id="address" placeholder="{{ __('Address') }}"
                @if(isset($venue))
                    value="{{ $venue->address }}"
                @endif
            />
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-label">
            <label for="courts">{{ __('# of courts') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input type="number" class="form-control" autocomplete="off" name="courts" id="courts" placeholder="{{ __('# of courts') }}"
                @if(isset($venue))
                    value="{{ $venue->courts }}"
                @endif
            />
        </div>
    </div>
    <div class="yjrb29-buttons-row">
        <div class="yjrb29-show-page-button yjrb29-form-first-button">
            @if(isset($venue))
                <input type="reset" class="yjrb29-btn-blue" value="{{ __('Reset') }}"/>
            @endif
        </div>
        <div class="yjrb29-show-page-button">
            <a href="{{route('venues')}}" class="yjrb29-btn-red">{{ __('Cancel') }}</a>
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
