<script type="text/ng-template" id="TemplatesClonerController.html">
    <div class="modal-header">
        <h3 class="modal-title">Choose One or More Templates</h3>
    </div>
    <div class="modal-body">

        <div class="checkbox checkbox-primary"  ng-repeat="template in templates">
            <input id="@{{ template.name }}-@{{ template.id }}" type="checkbox"
            ng-click="choose(template)">
            <label for="@{{ template.name }}-@{{ template.id }}">
                @{{ template.name }}
            </label>
        </div>

    </div>
    <div class="modal-footer">
        <button class="btn btn-warning" type="button" ng-click="cloneTemplates()">Choose</button>
        <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
    </div>
</script>