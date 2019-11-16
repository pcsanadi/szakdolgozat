@extends('layouts.app')

@section('header_scripts')
    @parent
@endsection

@section('content')
{{ __('New user') }}<br/>
<div class="container justify-content-center">
    <form action="{{route('users')}}" method="POST">
        @csrf
        <div class="form-group row">
            <label for="name" class="col-form-label">{{ __('Name') }}</label>
            <div class="col">
                <input type="text" class="form-control" name="name" id="name" placeholder="{{ __('Name') }}" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-form-label">{{ __('Email address') }}</label>
            <div class="col">
                <input type="email" class="form-control" name="email" id="email" placeholder="{{ __('Email address') }}" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-form-label">{{ __('Initial password') }}</label>
            <div class="col">
                <input type="text" class="form-control" name="password" id="password" placeholder="{{ __('Password') }}" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <label for="ulevel" class="col-form-label">{{ __('Umpire level') }}</label>
            <div class="col">
                <select id="ulevel" name="ulevel" class="form-control">
                    <option value="" selected disabled>{{ __('Choose') }}...</option>
                    @foreach($umpire_levels as $ulevel)
                        <option value="{{ $ulevel->id }}">{{$ulevel->level}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="rlevel" class="col-form-label">{{ __('Referee level') }}</label>
            <div class="col">
                <select id="rlevel" name="rlevel" class="form-control">
                    <option value="" selected disabled>{{ __('Choose') }}...</option>
                    @foreach($referee_levels as $rlevel)
                        <option value="{{ $rlevel->id }}">{{$rlevel->level}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="admin" class="col-sm-2 col-form-label">{{ __('Admin') }}</label>
            <div class="col-sm-10">
                <input id="admin" name="admin" value="admin" class="form-check-input" type="checkbox"/>
            </div>
        </div>
        <div class="form-group row">
            <div class="col">
                <a href="{{route('users')}}" class="btn">{{ __('Cancel') }}</a>
            </div>
            <div class="col">
                <input type="submit" class="btn" value="{{ __('Create') }}"/>
            </div>
        </div>
    </form>
</div>
@endsection
