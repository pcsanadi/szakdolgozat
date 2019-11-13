@extends('layouts.app')

@section('header_scripts')
    @parent
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 check -->
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 envelope -->
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <a href="{{route('users')}}/create" class="btn btn btn-outline-info">Új felhasználó</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <input class="form-check-input" type="checkbox" value="" id="showDeleted"/>
        </div>
        <div class="col">
            <label class="form-check-label" for="showDeleted">
                Töröltek megjelenítése
            </label>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col">
            @if( $users->count() == 0 )
                Nincs egyetlen felhasználó sem
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Név</th>
                            <th scope="col"><span class="far fa-envelope"></span></th>
                            <th scope="col">Jv szint</th>
                            <th scope="col">Döntnök szint</th>
                            <th scope="col">Admin</th>
                            <th scope="col">&nbsp;</th>
                            <th scope="col">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $users as $user )
                            @php($deleted = !is_null($user->deleted_at))
                            <tr @if($deleted)class="d-none"@endif>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->umpireLevel->level }}</td>
                                <td>{{ $user->refereeLevel->level }}</td>
                                <td>
                                    @if( $user->admin )
                                        <span class="fas fa-check"></span>
                                    @endif
                                </td>
                                <td>
                                    @if($deleted)
                                        <button type="button" class="btn" disabled>Szerkesztés</button>
                                    @else
                                        <a href="{{route('users')}}/{{$user->id}}" class="btn">
                                            Szerkesztés
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a href="" class="btn"
                                        onclick="event.preventDefault();document.getElementById('delete_form_{{$user->id}}').submit();">
                                        @if($deleted)
                                            Visszaállítás
                                        @else
                                            Törlés
                                        @endif
                                    </a>
                                    <form method="POST" id="delete_form_{{$user->id}}"
                                        @if($deleted)
                                            action="{{route('users')}}/{{$user->id}}/restore">
                                            @method('PUT')
                                        @else
                                            action="{{route('users')}}/{{$user->id}}">
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
