<div class="panel panel-default" ng-controller="SubscriptionChannelDetailsController">
    <div class="panel-body" ng-show="channelLoading">
        <p class="text-center">
            Initializing channel details...
        </p>
    </div>

    <div class="panel-heading text-right" ng-show="!channelLoading">
        <button ng-click="enableEdit()" ng-disabled="editMode" type="button" class="btn btn-warning" uib-tooltip="Edit" tooltip-trigger="mouseenter"><i class="fa fa-pencil"></i></button>
        <button ng-click="delete()" ng-disabled="editMode" type="button" class="btn btn-danger" uib-tooltip="Delete" tooltip-trigger="mouseenter"><i class="fa fa-trash"></i></button>
    </div>
    <div class="panel-body" ng-show="!channelLoading">
        <form class="form-horizontal">
            <div class="form-group" ng-class="{'has-error': editMode && errors.name.length > 0}">
                <label class="control-label col-md-4">Channel name</label>
                <div class="col-md-6">
                    <p class="form-control-static" ng-show="!editMode">@{{ channel.name }}</p>
                    <div ng-show="editMode">
                        <input type="text" name="name" class="form-control col-md-6" id="inputName" ng-model="channelCopy.name">
                        <span class="help-block" ng-show="errors.name.length > 0">
                            <strong>@{{ errors.name[0] }}</strong>
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="panel-footer text-right" ng-show="!channelLoading && editMode">
        <button class="btn btn-warning" ng-disabled="saving" type="button" ng-click="disableEdit()" uibtooltip="Cancel">Cancel</button>
        <button class="btn btn-success" ng-disabled="saving || !canSave()" type="button" ng-click="save()" uibtooltip="Save" ng-bind="saving ? 'Saving...' : 'Save'"></button>
    </div>
</div>