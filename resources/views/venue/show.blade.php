@extends('layouts.app')

@section('header_scripts')
    @parent
@endsection

@section('content')
<div class="container">
    <form action="{{url('/')}}/venues/{{$venue->id}}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Név</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" id="name" placeholder="Név" value="{{ $venue->name }}"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="address" class="col-sm-2 col-form-label">Cím</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="address" id="address" placeholder="Cím" value="{{ $venue->address }}"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="courts" class="col-sm-2 col-form-label">Pályák száma</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="courts" id="courts" placeholder="Pályák száma" value="{{ $venue->courts }}"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="accredited" class="col-sm-2 col-form-label">Akkreditált</label>
            <div class="col-sm-10">
                <input id="accredited" name="accredited" value="accredited" class="form-check-input" type="checkbox"
                    @if($venue->accredited == 1)
                        checked
                    @endif
                />
            </div>
        </div>
        <div class="form-group row">
            <input type="reset" class="btn btn-outline-info"/>
            <a href="{{url('/')}}/venues" class="btn btn-outline-info">Mégsem</a>
            <input type="submit" class="btn btn-outline-info" value="Mentés"/>
        </div>
    </form>
</div>
@endsection
