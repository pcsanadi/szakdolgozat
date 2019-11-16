@extends('layouts.app')

@section('header_scripts')
    @parent
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 check -->
@endsection

@section('content')
{{ __('Venues') }}<br/>
<div class="container">
    <div class="row">
        <div class="col">
            <a href="{{route('venues')}}/create" class="btn">{{ __('New venue') }}</a>
        </div>
    </div>
    @if( $venues->count() > 0 )
        <div class="row">
            <div class="col">
                <input class="form-check-input cbShowDeleted" type="checkbox"
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
                        <th scope="col">{{ __('Address') }}</th>
                        <th scope="col">{{ __('# of courts') }}</th>
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
                                    <button type="button" class="btn" disabled>{{ __('Edit') }}</button>
                                @else
                                    <a href="{{route('venues')}}/{{$venue->id}}" class="btn">
                                        {{ __('Edit') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                <a href="" class="btn"
                                    onclick="event.preventDefault();document.getElementById('delete_form_{{$venue->id}}').submit();">
                                    @if($deleted)
                                        {{ __('Restore') }}
                                    @else
                                        {{ __('Delete') }}
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
