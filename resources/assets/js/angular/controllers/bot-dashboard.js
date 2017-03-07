angular
    .module("messengerBotApp")
    .controller("BotDashboardController", function ($scope, $uibModal, FacebookService, $http, toastr, SweetAlert) {
        /**
         * Set initial bot.
         *
         * @type {{}}
         */
        $scope.bot = {};

        /**
         * Determine if bot is loading.
         *
         * @type {boolean}
         */
        $scope.botLoading = true;

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
         * Execute page connection to a bot.
         *
         * @param bot
         * @param page
         */
        var connectPage = function (bot, page) {
            $http
                .post(BASE_URL + "/api/bot/" + bot.id + "/page/connect", { page: page })
                .then(function (response) {
                    bot.page_id = response.data.page_id;
                    bot.page_title = response.data.page_title;
                    bot.page_token = response.data.page_token;
                    bot.page_token_expires_at = response.data.page_token_expires_at;
                    bot.app_subscribed = response.data.app_subscribed;

                    toastr.success("Facebook page \"" + page.name + "\" connected successfully.");
                }, function () {
                    toastr.error("Failed to connect facebook page to this bot.");
                });
        };

        /**
         * Load active bot.
         */
        $http.get(BASE_URL + "/api/bot/" + PROJECT_ID).then(function (response) {
            $scope.bot = response.data;

            $scope.botLoading = false;

            $scope.$broadcast("bot.loaded", $scope.bot);
        });

        /**
         * Open modal with pages list.
         *
         * @param bot
         */
        $scope.connectPage = function (bot) {
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
                                connectPage(bot, page);
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
         * @param bot
         */
        $scope.disconnectPage = function (bot) {
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
                        .delete(BASE_URL + "/api/bot/" + bot.id + "/page/disconnect")
                        .then(function (response) {
                            if (response.data.success) {
                                bot.page_id = null;
                                bot.page_title = null;
                                bot.page_token = null;
                                bot.page_token_expires_at = null;
                                bot.app_subscribed = false;

                                toastr.success("Facebook page disconnected successfully.");
                            } else {
                                toastr.error("Failed to disconnect facebook page to this bot.");
                            }
                        }, function () {
                            toastr.error("Failed to disconnect facebook page to this bot.");
                        });
                }

                SweetAlert.close();
            });
        };
    });