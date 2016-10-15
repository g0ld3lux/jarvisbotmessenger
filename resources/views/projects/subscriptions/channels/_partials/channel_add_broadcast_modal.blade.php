<script type="text/ng-template" id="SubscriptionChannelAddBroadcastController.html">
    <div class="modal-header">
        <button type="button" class="close" ng-click="cancel()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Broadcast new content</h4>
    </div>
    <form class="form-horizontal" role="form" name="newBroadcast">
        <div class="modal-body">
            <div class="form-group" ng-class="{'has-error': errors.name.length > 0}">
                <label class="control-label col-md-4">Name</label>
                <div class="col-md-8">
                    <input type="text" name="name" class="form-control" ng-model="broadcast.name">
                    <span class="help-block" ng-show="errors.name.length > 0">
                        <strong>@{{ errors.name[0] }}</strong>
                    </span>
                </div>
            </div>
            <div class="form-group" ng-class="{'has-error': errors.respond.length > 0}">
                <label class="control-label col-md-4">Respond to broadcast</label>
                <div class="col-md-8">
                    <p ng-show="respondsLoading">Loading...</p>
                    <p ng-show="!respondsLoading && responds.length <= 0">There is no responds to send...</p>
                    <div ng-show="!respondsLoading && responds.length > 0">
                        <ui-select ng-model="broadcast.respond" theme="bootstrap">
                            <ui-select-match>
                                @{{ $select.selected.title }}
                            </ui-select-match>
                            <ui-select-choices repeat="respond in (responds | filter: $select.search) track by respond.id">
                                <span ng-bind="respond.title"></span>
                            </ui-select-choices>
                        </ui-select>
                        <span class="help-block" ng-show="errors.respond.length > 0">
                            <strong>@{{ errors.respond[0] }}</strong>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group" ng-class="{'has-error': errors.scheduled_at.length > 0}">
                <label class="control-label col-md-4">Schedule at</label>
                <div class="col-md-8">
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
                <div class="col-md-8">
                    <select name="timezone" class="form-control" ng-model="broadcast.timezone">
                        <option value="project">by Project timezone</option>
                        <option value="recipient">by Recipient timezone</option>
                    </select>
                    <span class="help-block" ng-show="errors.timezone.length > 0">
                        <strong>@{{ errors.timezone[0] }}</strong>
                    </span>
                </div>
            </div>
            <div class="form-group" ng-class="{'has-error': errors.interval.length > 0}">
                <label class="control-label col-md-4">Interval</label>
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" name="interval" placeholder="Interval" class="form-control" ng-model="broadcast.interval" aria-describedby="interval-addon">
                        <span class="input-group-addon" id="interval-addon">sec.</span>
                    </div>
                    <span class="help-block" ng-show="errors.interval.length > 0">
                        <strong>@{{ errors.interval[0] }}</strong>
                    </span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" ng-click="cancel()" class="btn btn-warning" ng-disabled="saving">Cancel</button>
            <button type="button" ng-click="save()" class="btn btn-primary" ng-disabled="saving">Broadcast</button>
        </div>
    </form>
</script>