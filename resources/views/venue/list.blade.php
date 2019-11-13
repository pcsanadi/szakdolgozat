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
    @if( $venues->count() > 0 )
        <div class="row">
            <div class="col">
                <input class="form-check-input" type="checkbox" id="cbShowDeleted"
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
                        <th scope="col">Cím</th>
                        <th scope="col">Pályák száma</th>
                        <th scope="col">&nbsp;</th>
                        <th scope="col">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $venues as $venue )
                        @php($deleted = !is_null($venue->deleted_at))
                        <tr
                            @if($deleted)
                                name="deleted_row"
                                @if($showDeleted!="true")
                                    class="d-none"
                                @endif
                            @endif
                        >
                            <td>{{ $venue->name }}</td>
                            <td>{{ $venue->address }}</td>
                            <td>{{ $venue->courts }}</td>
                            <td>
                                @if($deleted)
                                    <button type="button" class="btn" disabled>Szerkesztés</button>
                                @else
                                    <a href="{{route('venues')}}/{{$venue->id}}" class="btn">
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
