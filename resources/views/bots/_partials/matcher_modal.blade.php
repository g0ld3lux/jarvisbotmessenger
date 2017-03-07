<script type="text/ng-template" id="MatcherController.html">
    <div class="modal-header">
        <h3 class="modal-title">Edit phrase details</h3>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" role="form" name="matcherForm" ng-submit="save()">
            <div class="text-center">
                <div class="btn-group" role="group">
                    <button type="button" class="btn" ng-disabled="matcher.id" ng-class="{'btn-primary': matcher.type == 'text', 'btn-default': matcher.type != 'text'}" ng-click="matcher.type = 'text'" uib-tooltip="Match similar text" tooltip-trigger="mouseenter">text</button>
                    <button type="button" class="btn" ng-disabled="matcher.id" ng-class="{'btn-primary': matcher.type == 'equals', 'btn-default': matcher.type != 'equals'}" ng-click="matcher.type = 'equals'" uib-tooltip="Equally match incoming text" tooltip-trigger="mouseenter">equals</button>
                    <button type="button" class="btn" ng-disabled="matcher.id" ng-class="{'btn-primary': matcher.type == 'contains', 'btn-default': matcher.type != 'contains'}" ng-click="matcher.type = 'contains'" uib-tooltip="Incoming text should contain string" tooltip-trigger="mouseenter">contains</button>
                    <button type="button" class="btn" ng-disabled="matcher.id" ng-class="{'btn-primary': matcher.type == 'regex', 'btn-default': matcher.type != 'regex'}" ng-click="matcher.type = 'regex'" uib-tooltip="Match text by given regular expression" tooltip-trigger="mouseenter">regex</button>
                </div>
            </div>

            <hr>

            <p class="text-center" ng-show="!matcher.type">
                Please select type.
            </p>

            <div class="form-group" ng-class="{'has-error': errors.pattern.length > 0}" ng-show="matcher.type == 'regex'">
                <label class="col-md-4 control-label">Pattern</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" name="pattern" ng-model="matcher.p.pattern">

                    <span class="help-block" ng-show="errors.pattern.length > 0">
                        <strong>@{{ errors.pattern[0] }}</strong>
                    </span>
                </div>
            </div>

            <div class="form-group" ng-class="{'has-error': errors.text.length > 0}" ng-show="matcher.type == 'equals' || matcher.type == 'contains' || matcher.type == 'text'">
                <label class="col-md-4 control-label">Text</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" name="text" ng-model="matcher.p.text">

                    <span class="help-block" ng-show="errors.text.length > 0">
                        <strong>@{{ errors.text[0] }}</strong>
                    </span>
                </div>
            </div>

            <div class="form-group" ng-class="{'has-error': errors.sensitivity.length > 0}" ng-show="matcher.type == 'text'">
                <label class="col-md-4 control-label">Sensitivity</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" name="text" ng-model="matcher.p.sensitivity">

                    <span class="help-block" ng-show="errors.sensitivity.length > 0">
                        <strong>@{{ errors.sensitivity[0] }}</strong>
                    </span>
                </div>
            </div>

            <div class="form-group" ng-class="{'has-error': errors.case.length > 0}" ng-show="matcher.type == 'equals' || matcher.type == 'contains'">
                <div class="col-md-6 col-md-push-4">
                    <div class="radio">
                        <label>
                            <input type="radio" name="case" ng-model="matcher.p.case" value="sensitive">
                            Case sensitive
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="case" ng-model="matcher.p.case" value="insensitive">
                            Case insensitive
                        </label>
                    </div>

                    <span class="help-block" ng-show="errors.case.length > 0">
                        <strong>@{{ errors.case[0] }}</strong>
                    </span>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-warning" type="button" ng-click="cancel()" ng-disabled="validating">Cancel</button>
        <button class="btn btn-success" type="button" ng-click="save()" ng-disabled="validating" ng-bind="validating ? 'Validating...' : (matcher.hasOwnProperty('id') ? 'Update' : 'Add')"></button>
    </div>
</script>