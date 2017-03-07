@extends('layouts.app')

@push('head_scripts')
    <script type="text/javascript">
        var BOT_ID = {{ $bot->id }};
        var PROJECT_TIMEZONE = "{{ $bot->timezone }}";
    </script>
@endpush

@section('content')
    <div ng-controller="SubscriptionsChannelsController">
        <div class="content-header">
            <div class="container">
                <div class="clearfix">
                    <div class="pull-left content-header-title"><a href="{{ route('bots.show', $bot->id) }}">{{ $bot->title }}</a> &raquo; Channels</div>
                    <div class="pull-right">
                        @include('bots._partials.menu')
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            @notification()

            <uib-tabset active="0" ng-cloak>
                <uib-tab index="0">
                    <uib-tab-heading>
                        <i class="fa fa-btn fa-rss"></i>Subscriptions channels
                    </uib-tab-heading>
                    <div class="panel panel-default">
                        <div class="panel-body" ng-show="channelsLoading">
                            <p class="text-center">Initializing subscriptions channels...</p>
                        </div>
                        <div ng-show="!channelsLoading" ng-cloak class="datatables-disable-top-padding-margin">
                            <table datatable="" dt-options="dtOptions" dt-columns="dtColumns" dt-instance="dtInstanceCallback" class="table table-custom"></table>
                        </div>
                    </div>
                </uib-tab>
                <uib-tab index="1">
                    <uib-tab-heading>
                        <i class="fa fa-btn fa-area-chart"></i>Analytics
                    </uib-tab-heading>
                    <div class="panel panel-default" ng-controller="SubscriptionsChannelsAnalyticsController">
                        <div class="panel-heading">
                            <div class="clearfix">
                                <div class="pull-right" ng-cloak>
                                    <div date-range-picker ng-model="datePicker.date" options="datePicker.options" class="btn btn-default btn-xs analytics-date">
                                        <span>@{{ datePicker.date.startDate.format("MMM D, YYYY") }} - @{{ datePicker.date.endDate.format("MMM D, YYYY") }}</span> <b class="caret"></b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <p class="text-center" ng-show="analyticsLoading">Initializing analytics...</p>
                            <canvas ng-cloak ng-show="!analyticsLoading" height="282" class="chart chart-bar" chart-data="data" chart-labels="labels" chart-series="series" chart-options="options" chart-colors="colors"></canvas>
                        </div>
                    </div>
                </uib-tab>
                <uib-tab index="2">
                    <uib-tab-heading>
                        <i class="fa fa-btn fa-plus"></i>Add channel
                    </uib-tab-heading>
                    <div ng-controller="SubscriptionsChannelsCreateController">
                        <form class="form-horizontal" role="form" name="subscriptionChannelForm">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group" ng-class="{'has-error': errors.name.length > 0}">
                                        <label class="control-label col-md-4" for="inputName">Channel name</label>
                                        <div class="col-md-6">
                                            <input type="text" name="name" class="form-control col-md-6" id="inputName" ng-model="channel.name">
                                            <span class="help-block" ng-show="errors.name.length > 0">
                                                <strong>@{{ errors.name[0] }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-right">
                                    <button class="btn btn-success" type="button" ng-disabled="saving" ng-click="save()" ng-bind="saving ? 'Saving...' : 'Save'"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </uib-tab>
            </uib-tabset>
        </div>
    </div>
@endsection