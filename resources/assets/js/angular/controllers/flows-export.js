angular
    .module("messengerBotApp")
    .controller("FlowsExportController", function ($scope, $uibModalInstance, $http, $httpParamSerializer, botId) {
        /**
         * Set initial exporting state.
         *
         * @type {boolean}
         */
        $scope.exporting = false;

        /**
         * Set initial loading state.
         *
         * @type {boolean}
         */
        $scope.loading = true;

        /**
         * Set initial flows.
         *
         * @type {{}}
         */
        $scope.flows = [];

        /**
         * Selected flows.
         *
         * @type {{flows: Array}}
         */
        $scope.selected = { flows: [] };

        /**
         * Load flows.
         */
        $http.get(BASE_URL + "/api/bot/" + botId + "/flow").then(function (response) {
            $scope.flows = response.data;
        }).finally(function () {
            $scope.loading = false;
        });

        /**
         * Dismiss modal.
         */
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };

        /**
         * Process save.
         */
        $scope.export = function () {
            window.open(
                BASE_URL + "/api/bot/" + botId + "/flow/export?" + $httpParamSerializer({
                    "flows[]": _.map($scope.selected.flows, function (flow) {
                        return flow.id;
                    })
                })
            );
        };
    });