@extends('layouts.app')

@section('header_scripts')
    @parent
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 check -->
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{url('/')}}/venues/create" class="btn btn btn-outline-info">Új csarnok</a>
        </div>
        <div class="col-md-8">
            <input class="form-check-input" type="checkbox" value="" id="showDeleted"/>
            <label class="form-check-label" for="showDeleted">
                Töröltek megjelenítése
            </label>
        </div>
        <div class="col-md-8">
            <div class="card">
                @if( $venues->count() == 0 )
                    <div class="card-body">Nincs egyetlen csarnok sem</div>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="d-none" scope="col">#</th>
                                <th scope="col">Név</th>
                                <th scope="col">Cím</th>
                                <th scope="col">Pályák száma</th>
                                <th scope="col">Akkreditált</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $venues as $venue )
                                @php($deleted = !is_null($venue->deleted_at))
                                <tr>
                                    <th class="d-none" scope="row">{{ $venue->id}}</th>
                                    <td>{{ $venue->name }}</td>
                                    <td>{{ $venue->address }}</td>
                                    <td>{{ $venue->courts }}</td>
                                    <td>
                                        @if( $venue->accredited )
                                            <span class="fas fa-check"></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($deleted)
                                            <button type="button" class="btn btn-outline-info" disabled>Szerkesztés</button>
                                        @else
                                            <a href="{{Route('venues')}}/{{$venue->id}}" class="btn btn-outline-info">
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
                                                action="{{Route('venues')}}/{{$venue->id}}/restore">
                                                @method('PUT')
                                            @else
                                                action="{{Route('venues')}}/{{$venue->id}}">
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
</div>
@endsection
