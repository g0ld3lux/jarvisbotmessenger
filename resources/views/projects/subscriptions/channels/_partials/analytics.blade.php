<div class="panel panel-default" ng-controller="SubscriptionChannelRecipientsAnalyticsController">
    <div class="panel-heading">
        <div class="clearfix">
            <div class="pull-left">
                Recipients growth
            </div>
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

<div class="panel panel-default" ng-controller="SubscriptionChannelBroadcastsAnalyticsController">
    <div class="panel-heading">
        <div class="clearfix">
            <div class="pull-left">
                Broadcasted messages
            </div>
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