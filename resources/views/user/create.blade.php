@extends('layouts.app')

@section('header_scripts')
    @parent
@endsection

@section('content')
<div class="container justify-content-center">
    <form action="{{route('users')}}" method="POST">
        @csrf
        <div class="form-group row">
            <label for="name" class="col-form-label">Név</label>
            <div class="col">
                <input type="text" class="form-control" name="name" id="name" placeholder="Név" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-form-label">E-mail cím</label>
            <div class="col">
                <input type="email" class="form-control" name="email" id="email" placeholder="E-mail cím" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-form-label">Kezdeti jelszó</label>
            <div class="col">
                <input type="text" class="form-control" name="password" id="password" placeholder="Jelszó" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <label for="ulevel" class="col-form-label">Játékvezető szint</label>
            <div class="col">
                <select id="ulevel" name="ulevel" class="form-control">
                    <option value="" selected disabled>Válassz...</option>
                    @foreach($umpire_levels as $ulevel)
                        <option value="{{ $ulevel->id }}">{{$ulevel->level}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="rlevel" class="col-form-label">Döntnök szint</label>
            <div class="col">
                <select id="rlevel" name="rlevel" class="form-control">
                    <option value="" selected disabled>Válassz...</option>
                    @foreach($referee_levels as $rlevel)
                        <option value="{{ $rlevel->id }}">{{$rlevel->level}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="admin" class="col-sm-2 col-form-label">Admin</label>
            <div class="col-sm-10">
                <input id="admin" name="admin" value="admin" class="form-check-input" type="checkbox"/>
            </div>
        </div>
        <div class="form-group row">
            <div class="col">
                <a href="{{route('users')}}" class="btn">Mégsem</a>
            </div>
            <div class="col">
                <input type="submit" class="btn" value="Létrehozás"/>
            </div>
        </div>
    </form>
</div>
@endsection
