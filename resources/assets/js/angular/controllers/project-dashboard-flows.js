angular
    .module("messengerBotApp")
    .controller("ProjectDashboardFlowsController", function ($scope, toastr, $http, SweetAlert, $uibModal) {
        /**
         * Determine if flows are loading.
         *
         * @type {boolean}
         */
        $scope.flowsLoading = true;

        /**
         * Set initial flows.
         *
         * @type {Array}
         */
        $scope.flows = [];

        /**
         * Hovered flow ID.
         *
         * @type {null}
         */
        $scope.hoverFlow = null;

        /**
         * Set sortable options.
         *
         * @type {{}}
         */
        $scope.sortableOptions = {
            "ui-floating": true,
            "handle": ".drag-handle",
            placeholder: "flows-sortable-placeholder col-md-12",
            "stop": function (e, ui) {
                var positions = [];

                angular.forEach($scope.flows, function (flow, i) {
                    positions.push({
                        flow: flow.id,
                        position: i + 1
                    })
                });

                $http
                    .post(BASE_URL + "/api/project/" + PROJECT_ID + "/flow/sort", { sort: positions })
                    .then(function (response) {
                        if (response.data.success) {
                            toastr.success("Flow order changed.");
                        } else {
                            toastr.error('Failed to update flow order.');
                        }
                    }, function () {
                        toastr.error('Failed to update flow order.');
                    });
            }
        };

        /**
         * Display flow modal and process save.
         *
         * @param flow
         */
        var flowModal = function (flow) {
            var modalInstance = $uibModal.open({
                templateUrl: "FlowController.html",
                controller: "FlowController",
                size: "lg",
                resolve: {
                    flow: function () {
                        return angular.copy(flow);
                    },
                    project: function () {
                        return $scope.project;
                    }
                }
            });

            modalInstance.result.then(function (flow) {
                $http.get(BASE_URL + "/api/project/" + PROJECT_ID + "/flow/" + flow.id).then(function (response) {
                    if ($scope.flows.filter(function (item) { return item.id == response.data.id }).length <= 0) {
                        $scope.flows.push(response.data);
                    } else {
                        angular.forEach($scope.flows, function (item, i) {
                            if (response.data.id == item.id) {
                                $scope.flows[i] = response.data;
                            }
                        });
                    }
                }, function () {
                    toastr.error("Failed to load flow data.");
                });

                toastr.success("Flow saved successfully.");
            });
        };

        /**
         * Load flows.
         */
        var loadFlows = function () {
            $scope.flowsLoading = true;

            $http.get(BASE_URL + "/api/project/" + PROJECT_ID + "/flow").then(function (response) {
                $scope.flows = response.data;
            }).finally(function () {
                $scope.flowsLoading = false;
            });
        };

        loadFlows();

        /**
         * Delete flow.
         *
         * @param flow
         */
        $scope.deleteFlow = function (flow) {
            SweetAlert.swal({
                title: "Are you sure?",
                text: "You will not be able to recover this flow!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function (confirm){
                if (confirm) {
                    $http.delete(BASE_URL + "/api/project/" + PROJECT_ID + "/flow/" + flow.id).then(function (response) {
                        if (response.data.success) {
                            toastr.success("Flow deleted successfully.");
                            $scope.flows = $scope.flows.filter(function (item) {
                                return item !== flow;
                            });
                        } else {
                            toastr.error('Error occurred when deleting flow.');
                        }
                    }, function () {
                        toastr.error('Error occurred when deleting flow.');
                    });
                }

                SweetAlert.close();
            });
        };

        /**
         * Make flow default.
         *
         * @param flow
         */
        $scope.makeDefault = function (flow) {
            $http
                .post(BASE_URL + "/api/project/" + PROJECT_ID + "/flow/" + flow.id + "/default", {})
                .then(function (response) {
                    if (response.data.success) {
                        toastr.success("Default flow changed.");

                        angular.forEach($scope.flows, function (value) {
                            value.is_default = false;
                        });

                        flow.is_default = true;
                    } else {
                        toastr.error('Failed to update default flow.');
                    }
                }, function () {
                    toastr.error('Failed to update default flow.');
                });
        };

        /**
         * Remove default flow.
         *
         * @param flow
         */
        $scope.removeDefault = function (flow) {
            $http
                .delete(BASE_URL + "/api/project/" + PROJECT_ID + "/flow/" + flow.id + "/default", {})
                .then(function (response) {
                    if (response.data.success) {
                        toastr.success("Default flow removed.");
                        flow.is_default = false;
                    } else {
                        toastr.error('Failed to remove default flow.');
                    }
                }, function () {
                    toastr.error('Failed to remove default flow.');
                });
        };

        /**
         * Call flow modal with selected flow.
         *
         * @param flow
         */
        $scope.editFlow = function (flow) {
            flowModal(flow);
        };

        /**
         * Call flow modal with empty flow.
         */
        $scope.addFlow = function () {
            flowModal({});
        };

        /**
         * Return URL to respond
         *
         * @param respond
         * @returns {string}
         */
        $scope.respondHref = function (respond) {
            return BASE_URL + "/projects/" + PROJECT_ID + "/responds/" + respond.id + "/edit";
        };

        /**
         * Show export modal.
         */
        $scope.export = function () {
            $uibModal.open({
                templateUrl: "FlowsExportController.html",
                controller: "FlowsExportController",
                resolve: {
                    projectId: function () {
                        return PROJECT_ID;
                    }
                }
            });
        };

        /**
         * Show import modal.
         */
        $scope.import = function () {
            var modalInstance = $uibModal.open({
                templateUrl: "FlowsImportController.html",
                controller: "FlowsImportController",
                resolve: {
                    projectId: function () {
                        return PROJECT_ID;
                    }
                }
            });

            modalInstance.result.then(function (result) {
                if (result) {
                    toastr.success("Flows were imported successfully.");
                    loadFlows();
                }
            });
        };
    });