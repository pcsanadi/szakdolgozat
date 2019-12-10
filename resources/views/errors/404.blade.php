@extends('layouts.app')

@section('content')
<div class="row justify-content-center" style="font-size: 26px;">
    <div class="col col-auto" style="position:relative;align-items:center;display:flex;color:#636b6f;">
        <div class="row">
            <div class="col" style="border-right:2px solid;">
                404
            </div>
            <div class="col-auto">
                {{ __('Page not found') }}
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col col-auto">
        <a href="{{ route('calendar') }}">{{ __('Tournament calendar') }}</a>
    </div>
</div>
@endsection
