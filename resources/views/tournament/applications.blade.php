@extends('layouts.app')

@section('header_scripts')
    @parent
    <script src="https://kit.fontawesome.com/d53001d225.js" crossorigin="anonymous"></script> <!-- Font Awesome 5 -->
@endsection

@section('content')
<div class="row yjrb29-page-title-bottom-padding">
    <div class="col-auto" title="
{{ __('Start date') }}: {{ $tournament->datefrom->format('Y. m. d.') }}
{{ __('End date') }}: {{ $tournament->dateto->format('Y. m. d.') }}
{{ __('Venue') }}: {{ $tournament->venue->short_name }}
{{ __('Requested umpires') }}: {{ $tournament->requested_umpires }}
    ">{{ __('Edit applications') }} - {{ $tournament->title }}</div>
</div>
<form method="POST" action="{{route('saveApplications',$tournament->id)}}">
    @method('PUT')
    @csrf
    <div class="yjrb29-application-row">
        <div class="yjrb29-application-group">{{ __('Referee applications') }}</div>
        <div class="col-md-6">
            @if(!count($refereeApplications))
                <input type="text" readonly class="form-control-plaintext" id="referee_applications"
                        value="{{ __('There are no referee applications') }}"
                />
            @endif
        </div>
    </div>
    @foreach($refereeApplications as $application)
        <div class="yjrb29-application-row">
            <div class="yjrb29-application-name">{{ $application->user->name }}</div>
            <div class="col-md-2">
                <input  id="referee_application_processed_{{$application->id}}"
                        name="referee_application_processed_{{$application->id}}"
                        value="referee_application_processed_{{$application->id}}"
                        class="form-check-input" type="checkbox"
                        @if( $application->processed )
                            checked="checked"
                        @endif
                        onclick="document.getElementById('referee_application_approved_{{$application->id}}').disabled=this.checked;
                                    document.getElementById('referee_application_processed_{{$application->id}}_value').value=(this.checked?'1':'0');"
                />
                <label for="referee_application_processed_{{$application->id}}">
                    {{ __('Processed') }}
                </label>
                <input  id="referee_application_processed_{{$application->id}}_value"
                        name="referee_application_processed_{{$application->id}}_value"
                        value="{{$application->processed ? '1' : '0'}}"
                        type="hidden"/>
            </div>
            <div class="col-md-2">
                <input  id="referee_application_approved_{{$application->id}}"
                        name="referee_application_approved_{{$application->id}}"
                        value="referee_application_approved_{{$application->id}}"
                        class="form-check-input" type="checkbox"
                        @if( $application->processed )
                            disabled="disabled"
                        @endif
                        @if( $application->approved )
                            checked="checked"
                        @endif
                        onclick="document.getElementById('referee_application_approved_{{$application->id}}_value').value=(this.checked?'1':'0');"
                />
                <label for="referee_application_approved_{{$application->id}}">
                    {{ __('Approved') }}
                </label>
                <input  id="referee_application_approved_{{$application->id}}_value"
                        name="referee_application_approved_{{$application->id}}_value"
                        value="{{$application->approved ? '1' : '0'}}"
                        type="hidden"/>
            </div>
        </div>
    @endforeach
    <div class="yjrb29-application-row">
        <div class="yjrb29-application-group">{{ __('Umpire applications') }}</div>
        <div class="col-6">
            @if(!count($umpireApplications))
                <input type="text" readonly class="form-control-plaintext" id="referee_applications"
                        value="{{ __('There are no umpire applications') }}"
                />
            @endif
        </div>
    </div>
    @foreach($umpireApplications as $application)
        <div class="yjrb29-application-row">
            <div class="yjrb29-application-name">{{ $application->user->name }}</div>
            <div class="col-2">
                <input  id="umpire_application_processed_{{$application->id}}"
                        name="umpire_application_processed_{{$application->id}}"
                        value="umpire_application_processed_{{$application->id}}"
                        class="form-check-input" type="checkbox"
                        @if( $application->processed )
                            checked="checked"
                        @endif
                        onclick="document.getElementById('umpire_application_approved_{{$application->id}}').disabled=this.checked;
                                    document.getElementById('umpire_application_processed_{{$application->id}}_value').value=(this.checked?'1':'0');"
                />
                <label for="umpire_application_processed_{{$application->id}}">
                    {{ __('Processed') }}
                </label>
                <input  id="umpire_application_processed_{{$application->id}}_value"
                        name="umpire_application_processed_{{$application->id}}_value"
                        value="{{$application->processed ? '1' : '0'}}"
                        type="hidden"/>
            </div>
            <div class="col-2">
                <input  id="umpire_application_approved_{{$application->id}}"
                        name="umpire_application_approved_{{$application->id}}"
                        value="umpire_application_approved_{{$application->id}}"
                        class="form-check-input" type="checkbox"
                        @if( $application->processed )
                            disabled="disabled"
                        @endif
                        @if( $application->approved )
                            checked="checked"
                        @endif
                        onclick="document.getElementById('umpire_application_approved_{{$application->id}}_value').value=(this.checked?'1':'0')"
                />
                <label for="umpire_application_approved_{{$application->id}}">
                    {{ __('Approved') }}
                </label>
                <input  id="umpire_application_approved_{{$application->id}}_value"
                        name="umpire_application_approved_{{$application->id}}_value"
                        value="{{$application->approved ? '1' : '0'}}"
                        type="hidden"/>
            </div>
        </div>
    @endforeach
    <div class="yjrb29-buttons-row">
        <div class="yjrb29-show-page-button yjrb29-form-first-button">
            @if(count($refereeApplications) + count($umpireApplications))
                <input type="reset" class="yjrb29-btn-blue" value="{{ __('Reset') }}"/>
            @endif
        </div>
        <div class="yjrb29-show-page-button">
            <a href="{{route('tournaments')}}" class="yjrb29-btn-red">{{ __('Back') }}</a>
        </div>
        <div class="yjrb29-show-page-button">
            @if(count($refereeApplications) + count($umpireApplications))
                <input type="submit" class="yjrb29-btn-green" value="{{ __('Save') }}" />
            @endif
        </div>
    </div>
</form>
@endsection
