@extends('layouts.app')

@push('head_scripts')
    <script type="text/javascript">
        var MESSAGE_ID = {{ $message->id }};
        var PROJECT_ID = {{ $project->id }};
        var PROJECT_TIMEZONE = "{{ $project->timezone }}";
    </script>
@endpush

@section('content')
    <div ng-controller="MassMessageController">
        <div class="content-header">
            <div class="container">
                <div class="clearfix">
                    <div class="pull-left content-header-title"><a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a> &raquo; <a href="{{ route('projects.messages.index', $project->id) }}">Messages</a> &raquo; {{ $message->name }}</div>
                    <div class="pull-right">
                        @include('projects._partials.menu')
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            @notification()

            <uib-tabset active="0" ng-cloak>
                <uib-tab index="0">
                    <uib-tab-heading>
                        <i class="fa fa-btn fa-info"></i>Message details
                    </uib-tab-heading>
                    @include('projects.messages._partials.details')
                </uib-tab>
                <uib-tab index="1">
                    <uib-tab-heading>
                        <i class="fa fa-btn fa-clock-o"></i>Schedules
                    </uib-tab-heading>
                    @include('projects.messages._partials.schedules')
                </uib-tab>
            </uib-tabset>
        </div>
    </div>
@endsection