<div class="panel panel-default">
    <div class="panel-body" ng-show="broadcastLoading">
        <p class="text-center">
            Initializing broadcast details...
        </p>
    </div>

    <div class="panel-heading text-right" ng-show="!broadcastLoading">
        <button ng-click="delete()" ng-disabled="broadcast.isStarted || broadcast.isFinished" type="button" class="btn btn-danger" uib-tooltip="Delete" tooltip-trigger="mouseenter"><i class="fa fa-trash"></i></button>
    </div>
    <div class="panel-body" ng-show="!broadcastLoading">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-4">Broadcast name</label>
                <div class="col-md-6">
                    <p class="form-control-static">@{{ broadcast.name }}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Scheduled</label>
                <div class="col-md-6">
                    <p class="form-control-static">
                        <span ng-show="!broadcast.scheduled_at">-</span>
                        <span ng-show="broadcast.scheduled_at" project-time time="broadcast.scheduled_at"></span>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Finished</label>
                <div class="col-md-6">
                    <p class="form-control-static">
                        <span ng-show="!broadcast.finished_at">-</span>
                        <span ng-show="broadcast.finished_at" project-time time="broadcast.finished_at"></span>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Created</label>
                <div class="col-md-6">
                    <p class="form-control-static">
                        <span ng-show="!broadcast.created_at">-</span>
                        <span ng-show="broadcast.created_at" project-time time="broadcast.created_at"></span>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Respond</label>
                <div class="col-md-6">
                    <p class="form-control-static">
                        <span ng-show="!broadcast.respond">-</span>
                        <a ng-if="broadcast.respond" respond-href="broadcast.respond">@{{ broadcast.respond.title }}</a>
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>