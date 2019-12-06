@extends('layouts.app')

@section('content')
<div class="yjrb29-page-title">
    <div class="col-auto">{{ __('Venues') }}</div>
</div>
<div class="yjrb29-top-row">
    <div class="col">
        <a href="{{route('venues.create')}}" class="yjrb29-btn-green">{{ __('New venue') }}</a>
    </div>
    <div class="yjrb29-top-row-spacer"></div>
    @if( $venues->count() > 0 )
        <div class="yjrb29-col-show-deleted">
            <div class="yjrb29-form-check">
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
</div>
<div class="yjrb29-table-header-row">
    <div class="yjrb29-table-header-3">{{ __('Name') }}</div>
    <div class="yjrb29-table-header-2">{{ __('Short name') }}</div>
    <div class="yjrb29-table-header-3">{{ __('Address') }}</div>
    <div class="yjrb29-table-header-2">{{ __('# of courts') }}</div>
    <div class="yjrb29-table-header-1"></div>
    <div class="yjrb29-table-header-1"></div>
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
        <div class="yjrb29-table-cell-3">{{ $venue->name }}</div>
        <div class="yjrb29-table-cell-center-2">{{ $venue->short_name }}</div>
        <div class="yjrb29-table-cell-3">{{ $venue->address }}</div>
        <div class="yjrb29-table-cell-center-2">{{ $venue->courts }}</div>
        <div class="yjrb29-table-cell-center-1">
            @if(!$deleted)
                <a href="{{route('venues.show',$venue->id)}}" class="text-info">
                    <span class="fas fa-edit" title="{{ __('Edit') }}"></span>
                </a>
            @endif
        </div>
        <div class="yjrb29-table-cell-center-1">
            @if($deleted)
                <a href="#" class="text-success"
                    onclick="event.preventDefault();document.getElementById('restore_form_{{$venue->id}}').submit();">
                    <span class="fas fa-trash-restore" title="{{ __('Restore') }}"></span>
                </a>
                <form method="POST" id="restore_form_{{$venue->id}}" action="{{route('venues.restore',$venue->id)}}">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="showDeleted" value="{{$showDeleted}}"/>
                </form>
            @else
                <a href="#" class="text-danger"
                    onclick="event.preventDefault();document.getElementById('delete_form_{{$venue->id}}').submit();">
                    <span class="fas fa-trash-alt" title="{{ __('Delete') }}"></span>
                </a>
                <form method="POST" id="delete_form_{{$venue->id}}" action="{{route('venues.show',$venue->id)}}">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="showDeleted" value="{{$showDeleted}}"/>
                </form>
            @endif
        </div>
    </div>
@endforeach
@endsection
