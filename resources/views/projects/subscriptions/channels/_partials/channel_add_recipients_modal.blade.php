<script type="text/ng-template" id="SubscriptionChannelAddRecipientsController.html">
    <div class="modal-header">
        <button type="button" class="close" ng-click="cancel()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add recipients to a channel</h4>
    </div>
    <div class="modal-body">
        <p class="text-center" ng-show="recipientsLoading">Initializing recipients...</p>
        <div ng-show="!recipientsLoading" ng-cloak class="datatables-disable-top-padding-margin">
            <table datatable="" dt-options="dtOptions" dt-columns="dtColumns" dt-instance="dtInstanceCallback" class="table table-custom"></table>
        </div>
    </div>
</script>