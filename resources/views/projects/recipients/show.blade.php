@extends('layouts.app')

@push('head_scripts')
    <script type="text/javascript">
        var RECIPIENT_ID = {{ $recipient->id }};
        var PROJECT_ID = {{ $project->id }};
        var PROJECT_TIMEZONE = "{{ $project->timezone }}";
    </script>
@endpush

@section('content')
    <div ng-controller="RecipientController">
        <div class="content-header">
            <div class="container">
                <div class="clearfix">
                    <div class="pull-left content-header-title"><a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a> &raquo; <a href="{{ route('projects.recipients.index', $project->id) }}">Recipients</a> &raquo; @if($recipient->getPhotoUrl('recipient_small')) <img class="img-circle" src="{{ $recipient->getPhotoUrl('recipient_small') }}"> @endif {{ $recipient->display_name }}</div>
                    <div class="pull-right">
                        @include('projects._partials.menu')
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            @notification()

            <div class="alert alert-warning" ng-show="recipient.chat_disabled" ng-cloak>
                Auto chat for this user is disabled.
            </div>

            <uib-tabset active="0">
                <uib-tab index="0">
                    <uib-tab-heading>
                        <i class="fa fa-info fa-btn"></i>Recipient information
                    </uib-tab-heading>
                    <div ng-controller="RecipientDetailsController" class="panel panel-default">
                        <div ng-show="recipientLoading">
                            <div class="panel-body">
                                <p class="text-center">
                                    Initializing recipient details...
                                </p>
                            </div>
                        </div>

                        <div ng-cloak ng-show="!recipientLoading">
                            <div class="panel-body">
                                <div class="clearfix">
                                    <div class="pull-right" ng-if="recipient.id">
                                        <recipient-chat-status recipient="recipient"></recipient-chat-status>
                                        <a href="{{ route('projects.recipients.edit', [$project->id, $recipient->id]) }}" class="btn btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil fa-btn"></i>Edit</a>
                                        <button type="button" class="btn btn-info" uib-tooltip="Refresh data from API" tooltip-trigger="mouseenter" ng-click="refreshData(recipient)"><i class="fa fa-refresh fa-btn"></i>Refresh data</button>
                                    </div>
                                </div>

                                <hr>

                                <dl class="dl-horizontal" ng-repeat="variable in recipientVariables">
                                    <dt>@{{ variable.variable.name }}</dt>
                                    <dd><recipient-variable-value variable="variable"></recipient-variable-value></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </uib-tab>
                <uib-tab index="1">
                    <uib-tab-heading>
                        <i class="fa fa-rss fa-btn"></i>Subscribed channels
                    </uib-tab-heading>
                    <div ng-controller="RecipientChannelsController" class="panel panel-default">
                        <div ng-show="channelsLoading">
                            <div class="panel-body">
                                <p class="text-center">
                                    Initializing subscribed channels...
                                </p>
                            </div>
                        </div>

                        <div ng-cloak ng-show="!channelsLoading">
                            <div class="panel-body">
                                <div class="clearfix">
                                    <button type="button" class="btn btn-primary pull-right" ng-click="addToChannel()"><i class="fa fa-plus fa-btn"></i>Add to channel</button>
                                </div>

                                <hr>
                            </div>

                            <div class="datatables-disable-top-padding-margin">
                                <table datatable="" dt-options="dtOptions" dt-columns="dtColumns" dt-instance="dtInstanceCallback" class="table table-custom"></table>
                            </div>
                        </div>
                    </div>
                </uib-tab>
                <uib-tab index="2">
                    <uib-tab-heading>
                        <i class="fa fa-comments fa-btn"></i>History
                    </uib-tab-heading>
                    <div ng-controller="RecipientHistoryController" class="panel panel-default">
                        <div ng-show="historyLoading">
                            <div class="panel-body">
                                <p class="text-center">
                                    Initializing history...
                                </p>
                            </div>
                        </div>

                        <div ng-cloak ng-show="!historyLoading">
                            <div class="datatables-disable-top-padding-margin">
                                <table datatable="" dt-options="dtOptions" dt-columns="dtColumns" dt-instance="dtInstanceCallback" class="table table-custom"></table>
                            </div>
                        </div>
                    </div>
                </uib-tab>
            </uib-tabset>
        </div>
    </div>
@endsection

@push('ngTemplates')
    @include('projects.recipients._partials.add_channel_modal')
@endpush