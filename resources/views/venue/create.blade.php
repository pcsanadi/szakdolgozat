@extends('layouts.app')

@section('header_scripts')
    @parent
@endsection

@section('content')
{{ __('New venue') }}<br/>
<div class="container justify-content-center">
    <form action="{{route('venues')}}" method="POST">
        @csrf
        <div class="form-group row">
            <label for="name" class="col-form-label">{{ __('Name') }}</label>
            <div class="col">
                <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('Name') }}" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <label for="address" class="col-form-label">{{ __('Address') }}</label>
            <div class="col">
                <input type="text" class="form-control" name="address" id="address" placeholder="{{ __('Address') }}" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <label for="courts" class="col-form-label">{{ __('# of courts') }}</label>
            <div class="col">
                <input type="number" class="form-control" name="courts" id="courts" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <a href="{{route('venues')}}" class="btn">{{ __('Cancel') }}</a>
            <input type="submit" class="btn" value="{{ __('Create') }}"/>
        </div>
    </form>
</div>
@endsection
