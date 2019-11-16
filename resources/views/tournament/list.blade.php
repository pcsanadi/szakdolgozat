@extends('layouts.app')

@section('header_scripts')
    @parent
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 check -->
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 envelope -->
@endsection

@section('content')
{{ __('Tournaments') }}
<div class="container">
    <div class="row">
        <div class="col">
            <a href="{{route('tournaments')}}/create" class="btn">{{ __('New tournament')}}</a>
        </div>
    </div>
    @if( $tournaments->count() > 0 )
        <div class="row">
            <div class="col">
                <input class="form-check-input cbShowDeleted" type="checkbox" value=""
                    @if($showDeleted == "true")
                        checked="checked"
                    @endif
                />
                <label class="form-check-label" for="cbShowDeleted">
                    {{ __('Show deleted') }}
                </label>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">{{ __('Name') }}</th>
                        <th scope="col">{{ __('Start date') }}</th>
                        <th scope="col">{{ __('End date') }}</th>
                        <th scope="col">{{ __('Venue') }}</th>
                        <th scope="col">{{ __('International') }}</th>
                        <th scope="col">{{ __('Requested umpires') }}</th>
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
                                @if($tournament->international)
                                    <span class="fas fa-check"></span>
                                @endif
                            </td>
                            <td>{{$tournament->requested_umpires}}</td>
                            <td>
                                @if($deleted)
                                    <button type="button" class="btn" disabled>{{ __('Edit') }}</button>
                                @else
                                    <a href="{{route('tournaments')}}/{{$tournament->id}}" class="btn">
                                        {{ __('Edit') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                <a href="" class="btn"
                                    onclick="event.preventDefault();document.getElementById('delete_form_{{$tournament->id}}').submit();">
                                    @if($deleted)
                                        {{ __('Restore') }}
                                    @else
                                        {{ __('Delete') }}
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
