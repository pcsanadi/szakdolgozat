@extends('layouts.app')

@section('header_scripts')
    @parent
@endsection

@section('content')
<p class="yjrb29-page-title-bottom-padding">{{ __('New venue') }}</p>
<div class="container justify-content-center">
    <form action="{{route('venues')}}" method="POST">
        @csrf
        <div class="form-group row">
            <div class="yjrb29-form-left-spacer"></div>
            <div class="yjrb29-form-label">
                <label for="name">{{ __('Name') }}</label>
            </div>
            <div class="yjrb29-form-content">
                <input type="text" class="form-control" name="name" placeholder="{{ __('Name') }}" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <div class="yjrb29-form-left-spacer"></div>
            <div class="yjrb29-form-label">
                <label for="short_name">{{ __('Short name') }}</label>
            </div>
            <div class="yjrb29-form-content">
                <input type="text" class="form-control" name="short_name" placeholder="{{ __('Short name') }}" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <div class="yjrb29-form-left-spacer"></div>
            <div class="yjrb29-form-label">
                <label for="address">{{ __('Address') }}</label>
            </div>
            <div class="yjrb29-form-content">
                <input type="text" class="form-control" name="address" placeholder="{{ __('Address') }}" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <div class="yjrb29-form-left-spacer"></div>
            <div class="yjrb29-form-label">
                <label for="courts">{{ __('# of courts') }}</label>
            </div>
            <div class="yjrb29-form-content">
                <input type="number" class="form-control" name="courts" placeholder="{{ __('# of courts') }}" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <div class="yjrb29-form-left-spacer"></div>
            <div class="yjrb29-show-page-button"></div>
            <div class="yjrb29-show-page-button">
                <a href="{{route('venues')}}" class="yjrb29-btn-red">{{ __('Cancel') }}</a>
            </div>
            <div class="yjrb29-show-page-button">
                <input type="submit" class="yjrb29-btn-green" value="{{ __('Create') }}"/>
            </div>
        </div>
    </form>
</div>
@endsection
