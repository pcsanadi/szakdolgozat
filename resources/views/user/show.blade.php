@extends('layouts.app')

@section('header_scripts')
    @parent
@endsection

@section('content')
<div class="container justify-content-center">
    <form action="{{route('users')}}/{{$user->id}}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group row">
            <label for="name" class="col-form-label">Név</label>
            <div class="col">
                <input type="text" class="form-control" name="name" id="name" placeholder="Név" value="{{ $user->name }}"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-form-label">E-mail cím</label>
            <div class="col">
                <input type="email" class="form-control" name="email" id="email" placeholder="E-mail cím" value="{{ $user->email }}"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="ulevel" class="col-form-label">Játékvezető szint</label>
            <div class="col">
                <select id="ulevel" name="ulevel" class="form-control">
                    @foreach($umpire_levels as $ulevel)
                        <option value="{{ $ulevel->id }}"
                        @if($user->umpire_level == $ulevel->id)
                            selected
                        @endif
                        >{{$ulevel->level}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="rlevel" class="col-form-label">Döntnök szint</label>
            <div class="col">
                <select id="rlevel" name="rlevel" class="form-control">
                    @foreach($referee_levels as $rlevel)
                        <option value="{{ $rlevel->id }}"
                        @if($user->referee_level == $rlevel->id)
                            selected
                        @endif
                        >{{$rlevel->level}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="admin" class="col-form-label">Admin</label>
            <div class="col">
                <input id="admin" name="admin" value="admin" class="form-check-input" type="checkbox"
                    @if($user->admin == 1)
                        checked
                    @endif
                />
            </div>
        </div>
        <div class="form-group row">
            <div class="col">
                <input type="reset" class="btn"/>
            </div>
            <div class="col">
                <a href="{{route('users')}}" class="btn">Mégsem</a>
            </div>
            <div class="col">
                <input type="submit" class="btn" value="Mentés"/>
            </div>
        </div>
    </form>
</div>
@endsection
