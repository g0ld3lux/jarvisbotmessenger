@extends('layouts.app')

@push('head_scripts')
    <script type="text/javascript">
        var SUBSCRIPTION_CHANNEL_ID = {{ $channel->id }};
        var PROJECT_ID = {{ $project->id }};
        var PROJECT_TIMEZONE = "{{ $project->timezone }}";
    </script>
@endpush

@section('content')
    <div ng-controller="SubscriptionChannelController">
        <div class="content-header">
            <div class="container">
                <div class="clearfix">
                    <div class="pull-left content-header-title"><a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a> &raquo; <a href="{{ route('projects.subscriptions.channels.index', $project->id) }}">Channels</a> &raquo; {{ $channel->name }}</div>
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
                        <i class="fa fa-btn fa-info"></i>Channel details
                    </uib-tab-heading>
                    @include('projects.subscriptions.channels._partials.details')
                </uib-tab>
                <uib-tab index="1">
                    <uib-tab-heading>
                        <i class="fa fa-btn fa-area-chart"></i>Analytics
                    </uib-tab-heading>
                    @include('projects.subscriptions.channels._partials.analytics')
                </uib-tab>
                <uib-tab index="2">
                    <uib-tab-heading>
                        <i class="fa fa-btn fa-users"></i>Recipients
                    </uib-tab-heading>
                    @include('projects.subscriptions.channels._partials.recipients')
                </uib-tab>
                <uib-tab index="3">
                    <uib-tab-heading>
                        <i class="fa fa-btn fa-rss"></i>Broadcasts
                    </uib-tab-heading>
                    @include('projects.subscriptions.channels._partials.broadcasts')
                </uib-tab>
            </uib-tabset>
        </div>
    </div>
@endsection