<div class="panel panel-default">
    <div class="panel-body" ng-show="messageLoading">
        <p class="text-center">
            Initializing message details...
        </p>
    </div>

    <div class="panel-heading text-right" ng-show="!messageLoading">
        <button ng-click="delete()" ng-disabled="message.isStarted || message.isFinished" type="button" class="btn btn-danger" uib-tooltip="Delete" tooltip-trigger="mouseenter"><i class="fa fa-trash"></i></button>
    </div>
    <div class="panel-body" ng-show="!messageLoading">
        <form class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-md-4">Name</label>
                <div class="col-md-6">
                    <p class="form-control-static">@{{ message.name }}</p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Scheduled</label>
                <div class="col-md-6">
                    <p class="form-control-static">
                        <span ng-show="!message.scheduled_at">-</span>
                        <span ng-show="message.scheduled_at" project-time time="message.scheduled_at"></span>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Finished</label>
                <div class="col-md-6">
                    <p class="form-control-static">
                        <span ng-show="!message.finished_at">-</span>
                        <span ng-show="message.finished_at" project-time time="message.finished_at"></span>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Created</label>
                <div class="col-md-6">
                    <p class="form-control-static">
                        <span ng-show="!message.created_at">-</span>
                        <span ng-show="message.created_at" project-time time="message.created_at"></span>
                    </p>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Responds</label>
                <div class="col-md-6">
                    <p class="form-control-static" ng-show="!message.responds">-</p>
                    <ul class="list-inline form-control-static" ng-show="message.responds">
                        <li ng-repeat="respond in message.responds">
                            <a respond-href="respond">@{{ respond.title }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
</div>