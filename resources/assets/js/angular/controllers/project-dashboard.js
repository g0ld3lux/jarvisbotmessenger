angular
    .module("messengerBotApp")
    .controller("ProjectDashboardController", function ($scope, $uibModal, FacebookService, $http, toastr, SweetAlert) {
        /**
         * Set initial project.
         *
         * @type {{}}
         */
        $scope.project = {};

        /**
         * Determine if project is loading.
         *
         * @type {boolean}
         */
        $scope.projectLoading = true;

        /**
         * Show FB auth error.
         */
        var authError = function () {
            SweetAlert.swal({
                type: "error",
                title: "Failed to authenticate!",
                showCancelButton: false
            });
        };

        /**
         * Execute page connection to a project.
         *
         * @param project
         * @param page
         */
        var connectPage = function (project, page) {
            $http
                .post(BASE_URL + "/api/project/" + project.id + "/page/connect", { page: page })
                .then(function (response) {
                    project.page_id = response.data.page_id;
                    project.page_title = response.data.page_title;
                    project.page_token = response.data.page_token;
                    project.page_token_expires_at = response.data.page_token_expires_at;
                    project.app_subscribed = response.data.app_subscribed;

                    toastr.success("Facebook page \"" + page.name + "\" connected successfully.");
                }, function () {
                    toastr.error("Failed to connect facebook page to this project.");
                });
        };

        /**
         * Load active project.
         */
        $http.get(BASE_URL + "/api/project/" + PROJECT_ID).then(function (response) {
            $scope.project = response.data;

            $scope.projectLoading = false;

            $scope.$broadcast("project.loaded", $scope.project);
        });

        /**
         * Open modal with pages list.
         *
         * @param project
         */
        $scope.connectPage = function (project) {
            FacebookService.login().then(function () {
                FacebookService.me().then(function (userResponse) {
                    FacebookService.pages(userResponse.id).then(function (pagesResponse) {
                        if (pagesResponse.data.length > 0) {
                            var modalInstance = $uibModal.open({
                                templateUrl: "ConnectFacebookPageController.html",
                                controller: "ConnectFacebookPageController",
                                resolve: {
                                    pages: function () {
                                        return pagesResponse.data;
                                    }
                                }
                            });

                            modalInstance.result.then(function (page) {
                                connectPage(project, page);
                            });
                        } else {
                            SweetAlert.swal({
                                type: "info",
                                title: "No managed pages found!",
                                showCancelButton: false
                            });
                        }
                    }, function () {
                        authError();
                    });
                }, function () {
                    authError();
                });
            }, function () {
                authError();
            });
        };

        /**
         * Disconnect facebook page.
         *
         * @param project
         */
        $scope.disconnectPage = function (project) {
            SweetAlert.swal({
                title: "Are you sure?",
                text: "You will not be able to recover this state!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, disconnect page!",
                closeOnConfirm: false
            }, function (confirm){
                if (confirm) {
                    $http
                        .delete(BASE_URL + "/api/project/" + project.id + "/page/disconnect")
                        .then(function (response) {
                            if (response.data.success) {
                                project.page_id = null;
                                project.page_title = null;
                                project.page_token = null;
                                project.page_token_expires_at = null;
                                project.app_subscribed = false;

                                toastr.success("Facebook page disconnected successfully.");
                            } else {
                                toastr.error("Failed to disconnect facebook page to this project.");
                            }
                        }, function () {
                            toastr.error("Failed to disconnect facebook page to this project.");
                        });
                }

                SweetAlert.close();
            });
        };
    });