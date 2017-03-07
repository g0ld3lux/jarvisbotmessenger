<div class="panel panel-default" ng-controller="MassMessageSchedulesController">
    <div class="panel-body" ng-show="schedulesLoading">
        <p class="text-center">Initializing schedules...</p>
    </div>
    <div ng-show="!schedulesLoading" ng-cloak class="datatables-disable-top-padding-margin">
        <table datatable="" dt-options="dtOptions" dt-columns="dtColumns" dt-instance="dtInstanceCallback" class="table table-custom"></table>
    </div>
</div>