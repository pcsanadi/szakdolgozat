@extends('layouts.app')

@section('header_scripts')
    @parent
@endsection

@section('content')
<p class="yjrb29-page-title-bottom-padding">{{ __('Edit venue') }}</p>
<div class="container">
    <form action="{{route('showVenue',$venue->id)}}" method="POST" autocomplete="off">
        @method('PUT')
        @csrf
        <div class="form-group row">
            <div class="yjrb29-form-left-spacer"></div>
            <div class="yjrb29-form-label">
                <label for="name">{{ __('Name') }}</label>
            </div>
            <div class="yjrb29-form-content">
                <input type="text" class="form-control" name="name" placeholder="{{ __('Name') }}" value="{{ $venue->name }}"/>
            </div>
        </div>
        <div class="form-group row">
            <div class="yjrb29-form-left-spacer"></div>
            <div class="yjrb29-form-label">
                <label for="short_name">{{ __('Short name') }}</label>
            </div>
            <div class="yjrb29-form-content">
                <input type="text" class="form-control" name="short_name" placeholder="{{ __('Short name') }}" value="{{ $venue->short_name }}"/>
            </div>
        </div>
        <div class="form-group row">
            <div class="yjrb29-form-left-spacer"></div>
            <div class="yjrb29-form-label">
                <label for="address">{{ __('Address') }}</label>
            </div>
            <div class="yjrb29-form-content">
                <input type="text" class="form-control" name="address" placeholder="{{ __('Address') }}" value="{{ $venue->address }}"/>
            </div>
        </div>
        <div class="form-group row">
            <div class="yjrb29-form-left-spacer"></div>
            <div class="yjrb29-form-label">
                <label for="courts">{{ __('# of courts') }}</label>
            </div>
            <div class="yjrb29-form-content">
                <input type="number" class="form-control" name="courts" placeholder="{{ __('# of courts') }}" value="{{ $venue->courts }}"/>
            </div>
        </div>
        <div class="form-group row">
            <div class="yjrb29-form-left-spacer"></div>
            <div class="yjrb29-show-page-button">
                <input type="reset" class="yjrb29-btn-blue" value="{{ __('Reset') }}"/>
            </div>
            <div class="yjrb29-show-page-button">
                <a href="{{route('venues')}}" class="yjrb29-btn-red">{{ __('Cancel') }}</a>
            </div>
            <div class="yjrb29-show-page-button">
                <input type="submit" class="yjrb29-btn-green" value="{{ __('Save') }}"/>
            </div>
        </div>
    </form>
</div>
@endsection
