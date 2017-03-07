<div class="panel panel-default" ng-controller="SubscriptionChannelRecipientsController">
    <div class="panel-body" ng-show="recipientsLoading">
        <p class="text-center">Initializing recipients...</p>
    </div>
    <div class="panel-heading text-right" ng-show="!recipientsLoading">
        <button type="button" class="btn btn-primary" uib-tooltip="Add recipients" tooltip-trigger="mouseenter" ng-click="addRecipients()"><i class="fa fa-plus"></i></button>
    </div>
    <div ng-show="!recipientsLoading" ng-cloak class="datatables-disable-top-padding-margin">
        <table datatable="" dt-options="dtOptions" dt-columns="dtColumns" dt-instance="dtInstanceCallback" class="table table-custom"></table>
    </div>
</div>

@push('ngTemplates')
    @include('bots.subscriptions.channels._partials.channel_add_recipients_modal')
@endpush