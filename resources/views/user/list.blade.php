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
            <a href="{{route('users')}}/create" class="btn">Új felhasználó</a>
        </div>
    </div>
    @if( $users->count() > 0 )
        <div class="row">
            <div class="col">
                <input class="form-check-input" type="checkbox" value="" id="cbShowDeleted"
                    @if($showDeleted == "true")
                        checked="checked"
                    @endif
                    onclick="var d=document.getElementsByName('deleted_row');
                        for(var i=0;i<d.length;++i)
                        {
                            if(this.checked)
                                d[i].classList.remove('d-none');
                            else
                                d[i].classList.add('d-none');
                        }
                        var sd=document.getElementsByName('showDeleted');
                        for(var i=0;i<sd.length;++i)
                        {
                            sd[i].value=(this.checked?'true':'false');
                        }"
                />
                <label class="form-check-label" for="cbShowDeleted">
                    Töröltek megjelenítése
                </label>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col">
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
                        <tr
                            @if($deleted)
                                name="deleted_row"
                                @if($showDeleted!="true")
                                    class="d-none"
                                @endif
                            @endif
                        >
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
                                    <input type="hidden" name="showDeleted" id="showDeleted" value="{{$showDeleted}}"/>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
