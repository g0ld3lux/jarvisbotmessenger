@extends('layouts.app')

@push('head_scripts')
    <script type="text/javascript">
        var BOT_ID = {{ $bot->id }};
        var BOT_TIMEZONE = "{{ $bot->timezone }}";
    </script>
@endpush

@section('content')
    <div ng-controller="MassMessagesController">
        <div class="content-header">
            <div class="container">
                <div class="clearfix">
                    <div class="pull-left content-header-title"><a href="{{ route('bots.show', $bot->id) }}">{{ $bot->title }}</a> &raquo; Mass messages</div>
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
                        <i class="fa fa-btn fa-envelope"></i>Mass messages
                    </uib-tab-heading>
                    <div class="panel panel-default">
                        <div class="panel-body" ng-show="messagesLoading">
                            <p class="text-center">Initializing messages...</p>
                        </div>
                        <div ng-show="!messagesLoading" ng-cloak class="datatables-disable-top-padding-margin">
                            <table datatable="" dt-options="dtOptions" dt-columns="dtColumns" dt-instance="dtInstanceCallback" class="table table-custom"></table>
                        </div>
                    </div>
                </uib-tab>
                <uib-tab index="1">
                    <uib-tab-heading>
                        <i class="fa fa-btn fa-area-chart"></i>Analytics
                    </uib-tab-heading>
                    <div class="panel panel-default" ng-controller="MassMessagesAnalyticsController">
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
                        <i class="fa fa-btn fa-plus"></i>Schedule message
                    </uib-tab-heading>
                    <div ng-controller="MassMessagesCreateController">
                        <form class="form-horizontal" role="form" name="massMessageForm">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group" ng-class="{'has-error': errors.name.length > 0}">
                                        <label class="control-label col-md-4">Name</label>
                                        <div class="col-md-6">
                                            <input type="text" name="name" class="form-control" ng-model="message.name">
                                            <span class="help-block" ng-show="errors.name.length > 0">
                                                <strong>@{{ errors.name[0] }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group" ng-class="{'has-error': errors.responds.length > 0}">
                                        <label class="control-label col-md-4">Respond to send</label>
                                        <div class="col-md-6">
                                            <p ng-show="respondsLoading">Loading...</p>
                                            <p ng-show="!respondsLoading && responds.length <= 0">There is no responds to send...</p>
                                            <div ng-show="!respondsLoading && responds.length > 0">
                                                <ui-select ng-model="message.responds" theme="bootstrap" multiple>
                                                    <ui-select-match>
                                                        <span ng-bind="$item.title"></span>
                                                    </ui-select-match>
                                                    <ui-select-choices repeat="respond in (responds | filter: $select.search) track by respond.id">
                                                        <span ng-bind="respond.title"></span>
                                                    </ui-select-choices>
                                                </ui-select>
                                                <span class="help-block" ng-show="errors.responds.length > 0">
                                                    <strong>@{{ errors.responds[0] }}</strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" ng-class="{'has-error': errors.respond.length > 0}">
                                        <label class="control-label col-md-4">Send to</label>
                                        <div class="col-md-6">
                                            <p ng-show="recipientsLoading">Loading...</p>
                                            <p ng-show="!recipientsLoading && recipients.length <= 0">There is no recipients to send to...</p>
                                            <div ng-show="!recipientsLoading && recipients.length > 0">
                                                <ui-select ng-model="message.recipients" theme="bootstrap" multiple>
                                                    <ui-select-match>
                                                        <span ng-bind="$item.displayName"></span>
                                                    </ui-select-match>
                                                    <ui-select-choices repeat="recipient in (recipients | filter: $select.search) track by recipient.id">
                                                        <img ng-show="recipient.hasPicture" recipient-picture="recipient" class="img-circle"> <span ng-bind="recipient.displayName"></span>
                                                    </ui-select-choices>
                                                </ui-select>
                                                <span class="help-block" ng-show="errors.recipients.length > 0">
                                                    <strong>@{{ errors.respond[0] }}</strong>
                                                </span>
                                                <span class="help-block" ng-show="errors.recipients.length <= 0">
                                                    If none selected then all will be used.
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" ng-class="{'has-error': errors.scheduled_at.length > 0}">
                                        <label class="control-label col-md-4">Schedule at</label>
                                        <div class="col-md-6">
                                            <div class="input-group" >
                                                <span class="input-group-addon" id="select-schedule-time-addon"><i class="fa fa-clock-o"></i></span>
                                                <input date-range-picker ng-model="datePicker.date" options="datePicker.options" name="scheduled_at" type="text" class="form-control" id="select-schedule-time" aria-describedby="select-schedule-time-addon">
                                            </div>
                                            <span class="help-block" ng-show="errors.scheduled_at.length > 0">
                                                <strong>@{{ errors.scheduled_at[0] }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group" ng-class="{'has-error': errors.timezone.length > 0}">
                                        <label class="control-label col-md-4">&nbsp;</label>
                                        <div class="col-md-6">
                                            <select name="timezone" class="form-control" ng-model="message.timezone">
                                                <option value="bot">by Bot timezone</option>
                                                <option value="recipient">by Recipient timezone</option>
                                            </select>
                                            <span class="help-block" ng-show="errors.timezone.length > 0">
                                                <strong>@{{ errors.timezone[0] }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group" ng-class="{'has-error': errors.interval.length > 0}">
                                        <label class="control-label col-md-4">Interval</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="text" name="interval" placeholder="Interval" class="form-control" ng-model="message.interval" aria-describedby="interval-addon">
                                                <span class="input-group-addon" id="interval-addon">sec.</span>
                                            </div>
                                            <span class="help-block" ng-show="errors.interval.length > 0">
                                                <strong>@{{ errors.interval[0] }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-right">
                                    <button class="btn btn-success" type="button" ng-disabled="saving" ng-click="save()" ng-bind="saving ? 'Scheduling...' : 'Schedule'"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </uib-tab>
            </uib-tabset>
        </div>
    </div>
@endsection