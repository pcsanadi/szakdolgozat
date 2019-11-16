@extends('layouts.app')

@section('header_scripts')
    @parent
@endsection

@section('content')
{{ __('Edit venue') }}<br/>
<div class="container justify-content-center">
    <form action="{{route('venues')}}/{{$venue->id}}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group row">
            <label for="name" class="col-form-label">{{ __('Name') }}</label>
            <div class="col">
                <input type="text" class="form-control" name="name" id="name" placeholder="Név" value="{{ $venue->name }}"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="address" class="col-form-label">{{ __('Address') }}</label>
            <div class="col">
                <input type="text" class="form-control" name="address" id="address" placeholder="Cím" value="{{ $venue->address }}"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="courts" class="col-form-label">{{ __('# of courts') }}</label>
            <div class="col">
                <input type="number" class="form-control" name="courts" id="courts" placeholder="Pályák száma" value="{{ $venue->courts }}"/>
            </div>
        </div>
        <div class="form-group row">
            <div class="col">
                <input type="reset" class="btn" value="{{ __('Reset') }}"/>
            </div>
            <div class="col">
                <a href="{{route('venues')}}" class="btn">{{ __('Cancel') }}</a>
            </div>
            <div class="col">
                <input type="submit" class="btn" value="{{ __('Save') }}"/>
            </div>
        </div>
    </form>
</div>
@endsection
