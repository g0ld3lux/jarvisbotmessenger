<div class="panel panel-default" ng-controller="SubscriptionChannelBroadcastsController">
    <div class="panel-body" ng-show="broadcastsLoading">
        <p class="text-center">Initializing broadcasts...</p>
    </div>
    <div class="panel-heading text-right" ng-show="!broadcastsLoading">
        <button type="button" class="btn btn-primary" uib-tooltip="Broadcast new content" tooltip-trigger="mouseenter" ng-click="addBroadcast()"><i class="fa fa-plus"></i></button>
    </div>
    <div ng-show="!broadcastsLoading" ng-cloak class="datatables-disable-top-padding-margin">
        <table datatable="" dt-options="dtOptions" dt-columns="dtColumns" dt-instance="dtInstanceCallback" class="table table-custom"></table>
    </div>
</div>

@push('ngTemplates')
    @include('bots.subscriptions.channels._partials.channel_add_broadcast_modal')
@endpush