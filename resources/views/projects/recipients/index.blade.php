@extends('layouts.app')

@push('head_scripts')
    <script type="text/javascript">
        var PROJECT_ID = {{ $project->id }};
        var PROJECT_TIMEZONE = "{{ $project->timezone }}";
    </script>
@endpush

@section('content')
    <div ng-controller="RecipientsController">
        <div class="content-header">
            <div class="container">
                <div class="clearfix">
                    <div class="pull-left content-header-title"><a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a> &raquo; Recipients</div>
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
                        <i class="fa fa-btn fa-list"></i>Recipients
                    </uib-tab-heading>
                    <div class="panel panel-default">
                        <div class="panel-body" ng-show="recipientsLoading">
                            <p class="text-center">Initializing recipients...</p>
                        </div>
                        <div ng-show="!recipientsLoading" ng-cloak class="datatables-disable-top-padding-margin">
                            <table datatable="" dt-options="dtOptions" dt-columns="dtColumns" dt-instance="dtInstanceCallback" class="table table-custom"></table>
                        </div>
                    </div>
                </uib-tab>
                <uib-tab index="1">
                    <uib-tab-heading>
                        <i class="fa fa-btn fa-area-chart"></i>Analytics
                    </uib-tab-heading>
                    <div class="panel panel-default" ng-controller="RecipientsAnalyticsController">
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
            </uib-tabset>
        </div>
    </div>
@endsection