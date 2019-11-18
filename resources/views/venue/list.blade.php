@extends('layouts.app')

@section('header_scripts')
    @parent
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 check -->
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
                <div class="form-check" style="white-space:nowrap;">
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
    <div class="row yjrb29-table-header-row">
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
                    class="row yjrb29-table-row d-none"
                @else
                    class="row yjrb29-table-row"
                @endif
                name="deleted_row"
            @else
                class="row yjrb29-table-row"
            @endif>
            <div class="col-3 yjrb29-table-cell">{{ $venue->name }}</div>
            <div class="col-2 yjrb29-table-cell text-center">{{ $venue->short_name }}</div>
            <div class="col-3 yjrb29-table-cell pl-3">{{ $venue->address }}</div>
            <div class="col-2 yjrb29-table-cell text-center">{{ $venue->courts }}</div>
            <div class="col-1 yjrb29-table-cell">
                <div class="pr-3">
                    @if($deleted)
                        <a href="#" class="yjrb29-btn-blue d-none">{{ __('Edit') }}</a>
                    @else
                        <a href="{{route('showVenue',$venue->id)}}" class="yjrb29-btn-blue">{{ __('Edit') }}</a>
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
                        onclick="event.preventDefault();document.getElementById('restore_form_{{$venue->id}}').submit();">
                        {{ __('Restore') }}
                    </a>
                    <a href="#"
                        @if($deleted)
                            class="yjrb29-btn-red d-none"
                        @else
                            class="yjrb29-btn-red"
                        @endif
                        onclick="event.preventDefault();document.getElementById('delete_form_{{$venue->id}}').submit();">
                        {{ __('Delete') }}
                    </a>
                    <form method="POST" id="restore_form_{{$venue->id}}" action="{{route('restoreVenue',$venue->id)}}">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="showDeleted" id="showDeleted" value="{{$showDeleted}}"/>
                    </form>
                    <form method="POST" id="delete_form_{{$venue->id}}" action="{{route('showVenue',$venue->id)}}">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="showDeleted" id="showDeleted" value="{{$showDeleted}}"/>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
