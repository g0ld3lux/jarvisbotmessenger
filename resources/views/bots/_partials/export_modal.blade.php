<script type="text/ng-template" id="FlowsExportController.html">
    <div class="modal-header">
        <button type="button" class="close" ng-click="cancel()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Export bot flows</h4>
    </div>
    <div class="modal-body">
        <div class="text-center" ng-show="loading">Loading...</div>
        <div class="alert alert-info text-center" ng-cloak ng-show="!loading && flows.length <= 0">There are no flows to export</div>
        <form class="form-horizontal" role="form" name="form" ng-cloak ng-show="!loading && flows.length > 0">
            <div class="form-group">
                <div class="col-md-12">
                    <ui-select ng-model="selected.flows" theme="bootstrap" multiple>
                        <ui-select-match placeholder="Flows to export">
                            <span ng-bind="$item.title"></span>
                        </ui-select-match>
                        <ui-select-choices repeat="flow in (flows | filter: $select.search) track by flow.id">
                            <span ng-bind="flow.title"></span>
                        </ui-select-choices>
                    </ui-select>

                    <span class="help-block">
                        <strong>If none selected then ALL will be exported</strong>
                    </span>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
        <button class="btn btn-success" type="button" ng-click="export()" ng-disabled="loading || flows.length <= 0">Export</button>
    </div>
</script>