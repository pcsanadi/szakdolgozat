@extends('layouts.app')

@section('header_scripts')
    @parent
@endsection

@section('content')
<div class="container">
    <form action="{{route('tournaments')}}" method="POST">
        @csrf
        <div class="form-group row">
            <label for="name"class="col-form-label">{{ __('Title') }}</label>
            <div class="col">
                <input tpye="text" class="form-control" name="title" id="title" placeHolder="{{ __('Title') }}" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <label for="datefrom" class="col-form-label">{{ __('Start date') }}</label>
            <div class="col">
                <input type="text" class="datepicker" id="datefrom" name="datefrom" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <label for="dateto" class="col-form-label">{{ __('End date') }}</label>
            <div class="col">
                <input type="text" class=datepicker" id="dateto" name="dateto" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <label for="venue" class="col-form-label">{{ __('Venue') }}</label>
            <div class="col">
                <select id="venue" name="venue" class="form-control">
                    @foreach($venues as $venue)
                        <option value="{{ $venue->id }}">{{ $venue->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col">
                <a href="{{ route('tournaments') }}" class="btn">{{ __('Cancel') }}</a>
            </div>
            <div class="col">
                <input type="submit" class="btn" value="{{ __('Create') }}"/>
            </div>
        </div>
    </form>
</div>
@endsection
