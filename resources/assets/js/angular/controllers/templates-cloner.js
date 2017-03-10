angular
    .module("messengerBotApp")
    .controller("TemplatesClonerController", function ($scope, $http, $uibModalInstance, toastr, botId) {
        /**
         * Set initial exporting state.
         *
         * @type {boolean}
         */
        $scope.loading = false;

        $scope.templates = [];

        $scope.choosen = [];



        /**
         * Load Templates.
         */
        var loadTemplates = function () {
            // If templates are loaded then dont make an ajax call
            $scope.loading = true;
            $http.get(BASE_URL + "/api/templates/").then(function (response) {
                $scope.templates = response.data;
            }).finally(function () {
                $scope.loading = true;
            });
        };
        loadTemplates();
        /**
         * Dismiss modal.
         */
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };

        $scope.choose = function (template) {
            var found = _.indexOf($scope.choosen, template.id);
            if(found != -1) {
                $scope.choosen.splice(found, 1);
                toastr.warning("Unchecked: " + template.name);
            } else {
                $scope.choosen.push(template.id);
                toastr.success("Choosen: " + template.name);
            }
        };


        /**
         * Clone Templates
         */
        $scope.cloneTemplates = function () {
            $scope.loading = true;
            $scope.errors = {};
            var data = JSON.stringify({templates: $scope.choosen});

            $http.post(BASE_URL + "/api/loadTemplateToFlows/" + botId, data).then(function successCallback(response) {
                toastr.success("Templates Was Copied to Your Bot");
            }, function errorCallback(response) {
               toastr.error("Failed to Clone Templates");
            });
            $uibModalInstance.dismiss('cancel');

        };


    });