@extends('layouts.app')

@section('header_scripts')
    @parent
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 -->
@endsection

@section('content')
<p class="yjrb29-page-title">{{ __('Venues') }}</p>
<div class="container">
    <div class="yjrb29-top-row">
        <div class="yjrb29-col-create-new">
            <a href="{{route('createVenue')}}" class="yjrb29-btn-green">{{ __('New venue') }}</a>
        </div>
        <div class="yjrb29-top-row-spacer"></div>
        @if( $venues->count() > 0 )
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
        <div class="col-3 yjrb29-table-header">{{ __('Name') }}</div>
        <div class="col-2 yjrb29-table-header">{{ __('Short name') }}</div>
        <div class="col-3 yjrb29-table-header">{{ __('Address') }}</div>
        <div class="col-2 yjrb29-table-header">{{ __('# of courts') }}</div>
        <div class="col-1 yjrb29-table-header"></div>
        <div class="col-1 yjrb29-table-header"></div>
    </div>
    @foreach( $venues as $venue )
        @php($deleted = !is_null($venue->deleted_at))
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
            <div class="col-3 yjrb29-table-cell">{{ $venue->name }}</div>
            <div class="col-2 yjrb29-table-cell-center">{{ $venue->short_name }}</div>
            <div class="col-3 yjrb29-table-cell">{{ $venue->address }}</div>
            <div class="col-2 yjrb29-table-cell-center">{{ $venue->courts }}</div>
            <div class="col-1 yjrb29-table-cell-center">
                @if(!$deleted)
                    <a href="{{route('showVenue',$venue->id)}}" class="text-info">
                        <span class="fas fa-edit" title="{{ __('Edit') }}"></span>
                    </a>
                @endif
            </div>
            <div class="col-1 yjrb29-table-cell-center">
                @if($deleted)
                    <a href="#" class="text-success"
                        onclick="event.preventDefault();document.getElementById('restore_form_{{$venue->id}}').submit();">
                        <span class="fas fa-trash-restore" title="{{ __('Restore') }}"></span>
                    </a>
                    <form method="POST" id="restore_form_{{$venue->id}}" action="{{route('restoreVenue',$venue->id)}}">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="showDeleted" value="{{$showDeleted}}"/>
                    </form>
                @else
                    <a href="#" class="text-danger"
                        onclick="event.preventDefault();document.getElementById('delete_form_{{$venue->id}}').submit();">
                        <span class="fas fa-trash-alt" title="{{ __('Delete') }}"></span>
                    </a>
                    <form method="POST" id="delete_form_{{$venue->id}}" action="{{route('showVenue',$venue->id)}}">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="showDeleted" value="{{$showDeleted}}"/>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
