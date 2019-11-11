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
                                <th scope="col">Törölt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $users as $user )
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
                                    <td>
                                        @if (!is_null($user->deleted_at))
                                            X <!-- TODO make beautiful -->
                                        @else
                                            &nbsp;
                                        @endif
                                    </td>
                                    <td><a href="users/{{$user->id}}"><button type="button" class="btn btn-outline-info">Szerkesztés</button></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                    <!-- </div> -->

                <!--<div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in! ({{ Auth::user()->l}})
                </div> -->
            </div>
        </div>
    </div>
</div>
@endsection
