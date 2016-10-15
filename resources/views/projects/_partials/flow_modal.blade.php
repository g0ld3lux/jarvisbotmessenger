<script type="text/ng-template" id="FlowController.html">
    <div class="modal-header">
        <h3 class="modal-title">Edit flow details</h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" role="form" name="flowForm" ng-submit="save()">
            <div class="form-group" ng-class="{'has-error': errors.title.length > 0}">
                <label class="col-md-4 control-label">Title</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" name="title" ng-model="flow.title">

                    <span class="help-block" ng-show="errors.title.length > 0">
                        <strong>@{{ errors.title[0] }}</strong>
                    </span>
                </div>
            </div>

            <hr>

            <div class="matchers">
                <p class="text-center text-muted">If user says something similar to:</p>

                <div ng-class="{'text-center': flow.matchers.length <= 0 || !flow.matchers}">
                    <span class="matcher" ng-repeat="matcher in flow.matchers">
                        <div class="btn-group btn-group-xs" role="group">
                            <button class="btn" type="button" ng-class="{'btn-primary': !isMatcherDeleted(matcher), 'btn-default': isMatcherDeleted(matcher)}">
                                <span ng-show="matcher.type == 'contains'">
                                    <span matcher-param="matcher" param="text"></span>
                                </span>
                                <span ng-show="matcher.type == 'equals'">
                                    <span matcher-param="matcher" param="text"></span>
                                </span>
                                <span ng-show="matcher.type == 'regex'">
                                    <span matcher-param="matcher" param="pattern"></span>
                                </span>
                                <span ng-show="matcher.type == 'text'">
                                    <span matcher-param="matcher" param="text"></span> <small class="text-muted">(<span matcher-param="matcher" param="sensitivity"></span>)</small>
                                </span>
                                <span class="badge">@{{ matcher.type }}</span>
                            </button>
                            <button type="button" ng-show="isMatcherDeleted(matcher)" ng-click="restoreMatcher(matcher)" uib-tooltip="Cancel delete" tooltip-trigger="mouseenter" class="btn btn-info"><i class="fa fa-ban"></i></button>
                            <button type="button" ng-show="!isMatcherDeleted(matcher)" ng-click="editMatcher(matcher)" uib-tooltip="Edit phrase" tooltip-trigger="mouseenter" class="btn btn-warning"><i class="fa fa-pencil"></i></button>
                            <button type="button" ng-show="!isMatcherDeleted(matcher)" ng-click="deleteMatcher(matcher)" uib-tooltip="Delete phrase" tooltip-trigger="mouseenter" class="btn btn-danger"><i class="fa fa-times"></i></button>
                        </div>
                    </span>

                    <button type="button" class="btn btn-primary btn-xs" uib-tooltip="Add phrase" tooltip-trigger="mouseenter" ng-click="addMatcher()"><i class="fa fa-plus"></i></button>
                </div>
            </div>

            <hr>

            <p class="text-center text-muted">Then show them:</p>

            <div class="form-group" ng-class="{'has-error': errors.responds.length > 0}">
                <div class="col-md-10 col-md-push-1">
                    <ui-select ng-model="flow.responds" theme="bootstrap" multiple>
                        <ui-select-match>
                            <span ng-bind="$item.title"></span>
                        </ui-select-match>
                        <ui-select-choices repeat="respond in (responds | filter: $select.search) track by respond.id">
                            <span ng-bind="respond.title"></span>
                        </ui-select-choices>
                    </ui-select>

                    <span class="help-block" ng-show="errors.responds.length > 0">
                        <strong>@{{ errors.responds[0] }}</strong>
                    </span>
                </div>
            </div>

        </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-warning" type="button" ng-disabled="saving" ng-click="cancel()">Cancel</button>
        <button class="btn btn-success" type="button" ng-disabled="saving" ng-click="save()" ng-bind="saving ? 'Saving...' : 'Save'"></button>
    </div>
</script>