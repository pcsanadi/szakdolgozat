@extends('layouts.app')

@section('header_scripts')
    @parent
    <script src='https://kit.fontawesome.com/a076d05399.js'></script> <!-- Font Awesome 5 -->
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-auto yjrb29-page-title">{{ __('Tournaments') }}</div>
</div>
<div class="yjrb29-top-row">
    <div class="yjrb29-col-create-new">
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
    <div class="col-3 yjrb29-table-header">{{ __('Name') }}</div>
    <div class="col-2 yjrb29-table-header">{{ __('Start date') }}</div>
    <div class="col-2 yjrb29-table-header">{{ __('End date') }}</div>
    <div class="col-1 yjrb29-table-header">{{ __('Venue') }}</div>
    <div class="col-2 yjrb29-table-header">{{ __('Requested umpires') }}</div>
    <div class="col-1 yjrb29-table-header"></div>
    <div class="col-1 yjrb29-table-header"></div>
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
        <div class="col-3 yjrb29-table-cell">{{$tournament->title}}</div>
        <div class="col-2 yjrb29-table-cell-center">{{date_format(date_create($tournament->datefrom),"Y. m. d.")}}</div>
        <div class="col-2 yjrb29-table-cell-center">{{date_format(date_create($tournament->dateto),"Y. m. d.")}}</div>
        <div class="col-1 yjrb29-table-cell-center">{{$tournament->venue->short_name}}</div>
        <div class="col-1 yjrb29-table-cell-center">{{$tournament->requested_umpires}}</div>
        <div class="col-1 yjrb29-table-cell-center">
            @if(!$deleted)
                <a href="{{route('applications',$tournament->id)}}" class="text-dark">
                    <span class="fas fa-user" title="{{ __('Edit applications')}}"></span>
                </a>
            @endif
        </div>
        <div class="col-1 yjrb29-table-cell-center">
            @if(!$deleted)
                <a href="{{route('showTournament',$tournament->id)}}" class="text-info">
                    <span class="fas fa-edit" title="{{ __('Edit') }}"></span>
                </a>
            @endif
        </div>
        <div class="col-1 yjrb29-table-cell-center">
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
