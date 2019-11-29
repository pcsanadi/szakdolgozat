@extends('layouts.app')

@section('header_scripts')
    @parent
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 -->
@endsection

@section('content')
<div class="yjrb29-page-title">
    <div class="col-auto">{{ __('Tournaments') }}</div>
</div>
<div class="yjrb29-top-row">
    <div class="col">
        <a href="{{route('createTournament')}}" class="yjrb29-btn-green">{{ __('New tournament')}}</a>
    </div>
    <div class="yjrb29-top-row-spacer"></div>
    @if( $tournaments->count() > 0 )
        <div class="yjrb29-col-show-deleted">
            <div class="yjrb29-form-check">
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
</div>
<div class="yjrb29-table-header-row">
    <div class="yjrb29-table-header-3">{{ __('Name') }}</div>
    <div class="yjrb29-table-header-2">{{ __('Start date') }}</div>
    <div class="yjrb29-table-header-2">{{ __('End date') }}</div>
    <div class="yjrb29-table-header-1">{{ __('Venue') }}</div>
    <div class="yjrb29-table-header-2">{{ __('Requested umpires') }}</div>
    <div class="yjrb29-table-header-2"></div>
</div>
@foreach( $tournaments as $tournament )
    @php($deleted = !is_null($tournament->deleted_at))
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
        <div class="yjrb29-table-cell-3">{{$tournament->title}}</div>
        <div class="yjrb29-table-cell-center-2">{{date_format(date_create($tournament->datefrom),"Y. m. d.")}}</div>
        <div class="yjrb29-table-cell-center-2">{{date_format(date_create($tournament->dateto),"Y. m. d.")}}</div>
        <div class="yjrb29-table-cell-center-1">{{$tournament->venue->short_name}}</div>
        <div class="yjrb29-table-cell-center-1">{{$tournament->requested_umpires}}</div>
        <div class="yjrb29-table-cell-center-1">
            @if(!$deleted)
                <a href="{{route('applications',$tournament->id)}}" class="text-dark">
                    <span class="fas fa-user" title="{{ __('Edit applications') }}"></span>
                </a>
                <a href="#" class="text-dark">
                    <span class="fas fa-envelope" title="{{ __('Send information email') }}"></span>
                </a>
            @endif
        </div>
        <div class="yjrb29-table-cell-center-1">
            @if(!$deleted)
                <a href="{{route('showTournament',$tournament->id)}}" class="text-info">
                    <span class="fas fa-edit" title="{{ __('Edit') }}"></span>
                </a>
            @endif
        </div>
        <div class="yjrb29-table-cell-center-1">
            @if($deleted)
                <a href="#" class="text-success"
                    onclick="event.preventDefault();document.getElementById('restore_form_{{$tournament->id}}').submit();">
                    <span class="fas fa-trash-restore" title="{{ __('Restore') }}"></span>
                </a>
                <form method="POST" id="restore_form_{{$tournament->id}}" action="{{route('restoreTournament',$tournament->id)}}">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="showDeleted" value="{{$showDeleted}}"/>
                </form>
            @else
                <a href="#" class="text-danger"
                    onclick="event.preventDefault();document.getElementById('delete_form_{{$tournament->id}}').submit();">
                    <span class="fas fa-trash-alt" title="{{ __('Delete') }}"></span>
                </a>
                <form method="POST" id="delete_form_{{$tournament->id}}" action="{{route('showTournament',$tournament->id)}}">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="showDeleted" value="{{$showDeleted}}"/>
                </form>
            @endif
        </div>
    </div>
@endforeach
@endsection
