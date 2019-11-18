@extends('layouts.app')

@section('header_scripts')
    @parent
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 check -->
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 envelope -->
@endsection

@section('content')
<p class="yjrb29-page-title">{{ __('Users') }}</p>
<div class="container">
    <div class="yjrb29-top-row">
        <div class="yjrb29-col-create-new">
            <a href="{{route('createUser')}}" class="yjrb29-btn-green">{{ __('New user') }}</a>
        </div>
        <div class="yjrb29-top-row-spacer"></div>
        @if( $users->count() > 0 )
            <div class="yjrb29-col-show-deleted">
                <div class="yjrb29-form-check">
                    <input class="form-check-input cbShowDeleted" type="checkbox"
                        @if($showDeleted == "true") checked="checked" @endif
                    />
                    <label class="form-check-label" for="cbShowDeleted">
                        {{ __('Show deleted') }}
                    </label>
                </div>
            </div>
        @endif
    </div>
    <div class="yjrb29-table-header-row">
            <div class="col-2 yjrb29-table-header">{{ __('Name') }}</div>
            <div class="col-3 yjrb29-table-header"><span class="far fa-envelope"></span></div>
            <div class="col-2 yjrb29-table-header">{{ __('U level') }}</div>
            <div class="col-2 yjrb29-table-header">{{ __('R level') }}</div>
            <div class="col-1 yjrb29-table-header">{{ __('Admin') }}</div>
            <div class="col-1 yjrb29-table-header"></div>
            <div class="col-1 yjrb29-table-header"></div>
    </div>
    @foreach( $users as $user )
        @php($deleted = !is_null($user->deleted_at))
        <div
            @if($deleted)
                @if($showDeleted!="true")
                    class="yjrb29-table-row d-none"
                @else
                    class="yjrb29-table-row"
                @endif
                name="deleted_row"
            @else
                class="yjrb29-table-row"
            @endif>
            <div class="col-2 yjrb29-table-cell">{{ $user->name }}</div>
            <div class="col-3 yjrb29-table-cell">{{ $user->email }}</div>
            <div class="col-2 yjrb29-table-cell text-center">{{ $user->umpireLevel->level }}</div>
            <div class="col-2 yjrb29-table-cell text-center">{{ $user->refereeLevel->level }}</div>
            <div class="col-1 yjrb29-table-cell text-center">@if( $user->admin )<span class="fas fa-check"></span>@endif</div>
            <div class="col-1 yjrb29-table-cell text-center">
                <div class="pr-3">
                    @if($deleted)
                        <a href="#" class="yjrb29-btn-blue d-none">{{ __('Edit') }}</a>
                    @else
                        <a href="{{route('showUser',$user->id)}}" class="yjrb29-btn-blue">{{ __('Edit') }}</a>
                    @endif
                </div>
            </div>
            <div class="col-1 yjrb29-table-cell">
                <div class="px-3">
                    <a href="#"
                        @if($deleted)
                            class="yjrb29-btn-green"
                        @else
                            class="yjrb29-btn-green d-none"
                        @endif
                        onclick="event.preventDefault();document.getElementById('restore_form_{{$user->id}}').submit();">
                        {{ __('Restore') }}
                    </a>
                    <a href="#"
                        @if($deleted)
                            class="yjrb29-btn-red d-none"
                        @else
                            class="yjrb29-btn-red"
                        @endif
                        onclick="event.preventDefault();document.getElementById('delete_form_{{$user->id}}').submit();">
                        {{ __('Delete') }}
                    </a>
                    <form method="POST" id="restore_form_{{$user->id}}" action="{{route('restoreUser',$user->id)}}">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="showDeleted" value="{{$showDeleted}}"/>
                    </form>
                    <form method="POST" id="delete_form_{{$user->id}}" action="{{route('showUser',$user->id)}}">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="showDeleted" value="{{$showDeleted}}"/>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
