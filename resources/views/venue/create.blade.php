@extends('layouts.app')

@section('header_scripts')
    @parent
@endsection

@section('content')
<div class="container justify-content-center">
    <form action="{{route('venues')}}" method="POST">
        @csrf
        <div class="form-group row">
            <label for="name" class="col-form-label">Név</label>
            <div class="col">
                <input type="text" class="form-control" name="name" id="name" placeholder="Név" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <label for="address" class="col-form-label">Cím</label>
            <div class="col">
                <input type="text" class="form-control" name="address" id="address" placeholder="Cím" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <label for="courts" class="col-form-label">Pályák száma</label>
            <div class="col">
                <input type="number" class="form-control" name="courts" id="courts" placeholder="Pályák száma" value=""/>
            </div>
        </div>
        <div class="form-group row">
            <a href="{{route('venues')}}" class="btn">Mégsem</a>
            <input type="submit" class="btn" value="Létrehozás"/>
        </div>
    </form>
</div>
@endsection
