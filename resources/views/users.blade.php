@extends('layouts.app')

@section('header_scripts')
    @parent
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 check -->
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 envelope -->
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if( $users->count() == 0 )
                    <div class="card-body">Nincs egyetlen felhasználó sem</div>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Név</th>
                                <th scope="col"><span class="far fa-envelope"></span></th>
                                <th scope="col">Jv szint</th>
                                <th scope="col">Döntnök szint</th>
                                <th scope="col">Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $users as $user )
                                @php($deleted = !is_null($user->deleted_at))
                                <tr>
                                    <th scope="row">{{ $user->id}}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->umpireLevel->level }}</td>
                                    <td>{{ $user->refereeLevel->level }}</td>
                                    <td>
                                        @if( $user->admin )
                                            <span class="fas fa-check"></span>
                                        @endif
                                    </td>
                                    <td><a href="{{Route('users')}}/{{$user->id}}" class="btn btn-outline-info">Szerkesztés</a></td>
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
                                                action="{{Route('users')}}/{{$user->id}}/restore">
                                                @method('PUT')
                                            @else
                                                action="{{Route('users')}}/{{$user->id}}">
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
