@extends('layouts.app')

@section('header_scripts')
    @parent
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 check -->
@endsection

@section('content')
<div class="container justify-content-center">
    <div class="row">
        <div class="col">
            <a href="{{route('venues')}}/create" class="btn">Új csarnok</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <input class="form-check-input" type="checkbox" id="cbShowDeleted"
            />
            <label class="form-check-label" for="cbShowDeleted">
                Töröltek megjelenítése
            </label>
        </div>
    </div>
    <div class="row">
        <div class="col">
            @if( $venues->count() == 0 )
                Nincs egyetlen csarnok sem
            @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Név</th>
                                <th scope="col">Cím</th>
                                <th scope="col">Pályák száma</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $venues as $venue )
                                @php($deleted = !is_null($venue->deleted_at))
                                <tr @if($deleted)class="d-none"@endif>
                                    <td>{{ $venue->name }}</td>
                                    <td>{{ $venue->address }}</td>
                                    <td>{{ $venue->courts }}</td>
                                    <td>
                                        @if($deleted)
                                            <button type="button" class="btn btn-outline-info" disabled>Szerkesztés</button>
                                        @else
                                            <a href="{{route('venues')}}/{{$venue->id}}" class="btn btn-outline-info">
                                                Szerkesztés
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="" class="btn"
                                            onclick="event.preventDefault();document.getElementById('delete_form_{{$venue->id}}').submit();">
                                            @if($deleted)
                                                Visszaállítás
                                            @else
                                                Törlés
                                            @endif
                                        </a>
                                        <form method="POST" id="delete_form_{{$venue->id}}"
                                            @if($deleted)
                                                action="{{route('venues')}}/{{$venue->id}}/restore">
                                                @method('PUT')
                                            @else
                                                action="{{route('venues')}}/{{$venue->id}}">
                                                @method('DELETE')
                                            @endif
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            @endif
        </div>
    </div>
</div>
@endsection
