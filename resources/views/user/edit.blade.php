@extends('layouts.app')

@section('header_scripts')
    @parent
@endsection

@section('content')
<div class="row justify-content-center yjrb29-page-title-bottom-padding">
    <div class="col-auto">
        @if(isset($user))
            {{ __('Edit user') }}
        @else
            {{ __('New user') }}
        @endif
    </div>
</div>
<form method="POST"
    @if(isset($user))
        action="{{route('showUser',$user->id)}}">
        @method('PUT')
    @else
        action="{{route('users')}}">
    @endif
    @csrf
    <div class="form-group row">
        <div class="yjrb29-form-left-spacer"></div>
        <div class="yjrb29-form-label">
            <label for="name">{{ __('Name') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('Name') }}"
                @if(isset($user))
                    value="{{ $user->name }}"
                @endif
            />
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-left-spacer"></div>
        <div class="yjrb29-form-label">
            <label for="email">{{ __('Email address') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('Email address') }}"
                @if(isset($user))
                    value="{{ $user->email }}"
                @endif
            />
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-left-spacer"></div>
        <div class="yjrb29-form-label">
            <label for="ulevel">{{ __('Umpire level') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <select id="ulevel" name="ulevel" class="form-control">
                <option value="" selected disabled>{{ __('Choose') }}...</option>
                @foreach($umpire_levels as $ulevel)
                    <option value="{{ $ulevel->id }}"
                        @if(isset($user) and $ulevel->id == $user->umpire_level)
                            selected
                        @endif
                    >{{$ulevel->level}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-left-spacer"></div>
        <div class="yjrb29-form-label">
            <label for="rlevel">{{ __('Referee level') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <select id="rlevel" name="rlevel" class="form-control">
                <option value="" selected disabled>{{ __('Choose') }}...</option>
                @foreach($referee_levels as $rlevel)
                    <option value="{{ $rlevel->id }}"
                        @if(isset($user) and $rlevel->id == $user->referee_level)
                            selected
                        @endif
                    >{{$rlevel->level}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-left-spacer"></div>
        <div class="yjrb29-form-label">
            <label for="admin">{{ __('Admin') }}</label>
        </div>
        <div class="yjrb29-form-content pt-3 text-center">
            <input id="admin" name="admin" value="admin" class="form-check-input" type="checkbox"
                @if(isset($user) and $user->admin)
                    checked="checked"
                @endif
            />
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-left-spacer"></div>
        <div class="yjrb29-show-page-button">
            @if(isset($user))
                <input type="reset" class="yjrb29-btn-blue" value="{{ __('Reset') }}"/>
            @endif
        </div>
        <div class="yjrb29-show-page-button">
            <a href="{{route('users')}}" class="yjrb29-btn-red">{{ __('Cancel') }}</a>
        </div>
        <div class="yjrb29-show-page-button">
            <input type="submit" class="yjrb29-btn-green"
                @if(isset($user))
                    value="{{ __('Save') }}"
                @else
                    value="{{ __('Create') }}"
                @endif
            />
        </div>
    </div>
</form>
@endsection
