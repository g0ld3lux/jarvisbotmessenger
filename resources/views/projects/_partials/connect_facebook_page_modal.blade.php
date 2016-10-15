<script type="text/ng-template" id="ConnectFacebookPageController.html">
    <div class="modal-header">
        <h3 class="modal-title">Select facebook page</h3>
    </div>
    <div class="modal-body">
        <div class="list-group">
            <a href="#" ng-click="select(page)" class="list-group-item" ng-repeat="page in pages">
                @{{ page.name }}
            </a>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
    </div>
</script>