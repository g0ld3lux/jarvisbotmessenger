<script type="text/ng-template" id="FlowsImportController.html">
    <div class="modal-header">
        <button type="button" class="close" ng-click="cancel()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Import bot flows</h4>
    </div>
    <div class="modal-body">
        <form class="form-horizontal" role="form" name="form">
            <div class="form-group" ng-class="{'has-error': errors.file.length > 0}">
                <label class="col-md-4 control-label">File</label>
                <div class="col-md-8">
                    <input type="file" ngf-select="" ng-model="file" name="file" ngf-accept="'application/json'" required class="form-control">
                    <span class="help-block" ng-show="errors.file.length > 0">
                        <strong>@{{ errors.file[0] }}</strong>
                    </span>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-warning" type="button" ng-click="cancel()" ng-disabled="importing">Cancel</button>
        <button class="btn btn-success" type="button" ng-click="import(file)" ng-disabled="importing" ng-bind="importing ? 'Importing...' : 'Import'"></button>
    </div>
</script>