@extends('layouts.app')

@section('header_scripts')
    @parent
@endsection

@section('content')
<div class="yjrb29-page-title-bottom-padding">
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
        action="{{route('users.show',$user->id)}}">
        @method('PUT')
    @else
        action="{{route('users.index')}}">
    @endif
    @csrf
    <div class="form-group row">
        <div class="yjrb29-form-label">
            <label for="name">{{ __('Name') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                autocomplete="off" id="name" name="name" required
                value="{{ old('name') ? old('name') : ( isset($user) ? $user->name : '') }}"
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
            <label for="email">{{ __('Email address') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <input type="email" class="form-control @error('email') is-invalid @enderror"
                autocomplete="off" id="email" name="email" required
                value="{{ old('email') ? old('email') : ( isset($user) ? $user->email : '' ) }}"
            />
            @error("email")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-label">
            <label for="ulevel">{{ __('Umpire level') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <select id="ulevel" name="ulevel" class="form-control @error('ulevel') is-invalid @enderror" required>
                <option value="" selected disabled>{{ __('Choose') }}...</option>
                @foreach($umpire_levels as $ulevel)
                    <option value="{{ $ulevel->id }}"
                        @if( old('ulevel') and $ulevel->id == old('ulevel') )
                            selected
                        @elseif(isset($user) and $ulevel->id == $user->umpire_level)
                            selected
                        @endif
                    >{{$ulevel->level}}</option>
                @endforeach
            </select>
            @error('ulevel')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-label">
            <label for="rlevel">{{ __('Referee level') }}</label>
        </div>
        <div class="yjrb29-form-content">
            <select id="rlevel" name="rlevel" class="form-control @error('rlevel') is-invalid @enderror" required>
                <option value="" selected disabled>{{ __('Choose') }}...</option>
                @foreach($referee_levels as $rlevel)
                    <option value="{{ $rlevel->id }}"
                        @if( old('rlevel') and $rlevel->id == old('rlevel') )
                            selected
                        @elseif(isset($user) and $rlevel->id == $user->referee_level)
                            selected
                        @endif
                    >{{$rlevel->level}}</option>
                @endforeach
            </select>
            @error('rlevel')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-form-label">
            <label for="admin">{{ __('Admin') }}</label>
        </div>
        <div class="yjrb29-form-content pt-md-1 text-center">
            <input id="admin" name="admin" value="admin" class="form-check-input" type="checkbox"
                @if(isset($user) and $user->admin)
                    checked="checked"
                @endif
            />
        </div>
    </div>
    <div class="form-group row">
        <div class="yjrb29-show-page-button yjrb29-form-first-button">
            @if(isset($user))
                <input type="reset" class="yjrb29-btn-blue" value="{{ __('Reset') }}"/>
            @endif
        </div>
        <div class="yjrb29-show-page-button">
            <a href="{{route('users.index')}}" class="yjrb29-btn-red">{{ __('Cancel') }}</a>
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
