@extends('layouts.app')

@section('header_scripts')
    @parent
@endsection

@section('content')
<div class="container">
    <form action="{{url('/')}}/users/{{$user->id}}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Név</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" id="name" placeholder="Név" value="{{ $user->name }}"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">E-mail cím</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" name="email" id="email" placeholder="E-mail cím" value="{{ $user->email }}"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="ulevel" class="col-sm-2 col-form-label">Játékvezető szint</label>
            <div class="col-sm-10">
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
            <label for="rlevel" class="col-sm-2 col-form-label">Döntnök szint</label>
            <div class="col-sm-10">
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
            <label for="admin" class="col-sm-2 col-form-label">Admin</label>
            <div class="col-sm-10">
                <input id="admin" name="admin" value="admin" class="form-check-input" type="checkbox"
                    @if($user->admin == 1)
                        checked
                    @endif
                />
            </div>
        </div>
        <div class="form-group row">
            <input type="reset" class="btn btn-outline-info"/>
            <a href="{{url('/')}}/users" class="btn btn-outline-info">Mégsem</a>
            <input type="submit" class="btn btn-outline-info" value="Mentés"/>
        </div>
    </form>
</div>
@endsection
