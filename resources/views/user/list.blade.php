@extends('layouts.app')

@section('header_scripts')
    @parent
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 check -->
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 envelope -->
@endsection

@section('content')
{{ __('Users') }}<br/>
<div class="container">
    <div class="row">
        <div class="col">
            <a href="{{route('createUser')}}" class="btn">{{ __('New user') }}</a>
        </div>
    </div>
    @if( $users->count() > 0 )
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
                        <th scope="col"><span class="far fa-envelope"></span></th>
                        <th scope="col">{{ __('U level') }}</th>
                        <th scope="col">{{ __('R level') }}</th>
                        <th scope="col">{{ __('Admin') }}</th>
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
                                    <button type="button" class="btn" disabled>{{ __('Edit') }}</button>
                                @else
                                    <a href="{{route('showUser',$user->id)}}" class="btn">
                                        {{ __('Edit') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                <a href="" class="btn"
                                    onclick="event.preventDefault();document.getElementById('delete_form_{{$user->id}}').submit();">
                                    @if($deleted)
                                        {{ __('Restore') }}
                                    @else
                                        {{ __('Delete') }}
                                    @endif
                                </a>
                                <form method="POST" id="delete_form_{{$user->id}}"
                                    @if($deleted)
                                        action="{{route('restoreUser',$user->id)}}">
                                        @method('PUT')
                                    @else
                                        action="{{route('showUser',$user->id)}}">
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
