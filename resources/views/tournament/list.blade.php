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
            <a href="{{route('tournaments')}}/create" class="btn">Új felhasználó</a>
        </div>
    </div>
    @if( $tournaments->count() > 0 )
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
                        <th scope="col">Kezdődátum</th>
                        <th scope="col">Végdátum</th>
                        <th scope="col">Csarnok</th>
                        <th scope="col">&nbsp;</th>
                        <th scope="col">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $tournaments as $tournament )
                        @php($deleted = !is_null($tournament->deleted_at))
                        <tr
                            @if($deleted)
                                name="deleted_row"
                                @if($showDeleted!="true")
                                    class="d-none"
                                @endif
                            @endif
                        >
                            <td>{{$tournament->title}}</td>
                            <td>{{date_format(date_create($tournament->datefrom),"Y. m. d.")}}</td>
                            <td>{{date_format(date_create($tournament->dateto),"Y. m. d.")}}</td>
                            <td>{{$tournament->venue->name}}</td>
                            <td>
                                @if($deleted)
                                    <button type="button" class="btn" disabled>Szerkesztés</button>
                                @else
                                    <a href="{{route('tournaments')}}/{{$tournament->id}}" class="btn">
                                        Szerkesztés
                                    </a>
                                @endif
                            </td>
                            <td>
                                <a href="" class="btn"
                                    onclick="event.preventDefault();document.getElementById('delete_form_{{$tournament->id}}').submit();">
                                    @if($deleted)
                                        Visszaállítás
                                    @else
                                        Törlés
                                    @endif
                                </a>
                                <form method="POST" id="delete_form_{{$tournament->id}}"
                                    @if($deleted)
                                        action="{{route('tournaments')}}/{{$tournament->id}}/restore">
                                        @method('PUT')
                                    @else
                                        action="{{route('tournaments')}}/{{$tournament->id}}">
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
