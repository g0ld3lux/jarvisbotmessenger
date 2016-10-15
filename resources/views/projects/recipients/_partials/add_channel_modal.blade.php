<script type="text/ng-template" id="RecipientAddToChannelController.html">
    <div class="modal-header">
        <button type="button" class="close" ng-click="cancel()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add recipient to a channel</h4>
    </div>
    <div class="modal-body">
        <div class="text-center" ng-show="loading">Loading...</div>
        <div class="alert alert-info text-center" ng-cloak ng-show="!loading && channels.length <= 0">All channels were added</div>
        <form class="form-horizontal" role="form" name="form" ng-submit="save()" ng-cloak ng-show="!loading && channels.length > 0">
            <div class="form-group" ng-class="{'has-error': errors.channels.length > 0}">
                <div class="col-md-12">
                    <ui-select ng-model="relation.channels" theme="bootstrap" multiple>
                        <ui-select-match placeholder="Channels">
                            <span ng-bind="$item.name"></span>
                        </ui-select-match>
                        <ui-select-choices repeat="channel in (channels | filter: $select.search) track by channel.id">
                            <span ng-bind="channel.name"></span>
                        </ui-select-choices>
                    </ui-select>

                    <span class="help-block" ng-show="errors.channels.length > 0">
                        <strong>@{{ errors.channels[0] }}</strong>
                    </span>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-warning" type="button" ng-disabled="saving" ng-click="cancel()">Cancel</button>
        <button class="btn btn-success" type="button" ng-disabled="saving || loading || channels.length <= 0" ng-click="save()" ng-bind="saving ? 'Saving...' : 'Save'"></button>
    </div>
</script>