angular
    .module("messengerBotApp")
    .controller("SubscriptionsChannelsCreateController", function ($scope, ApiUtils, $window, toastr) {
        /**
         * Set initial saving state.
         *
         * @type {boolean}
         */
        $scope.saving = false;

        /**
         * Set channel.
         *
         * @type {*}
         */
        $scope.channel = {};

        /**
         * Initial errors.
         *
         * @type {{}}
         */
        $scope.errors = {};

        /**
         * Process save.
         */
        $scope.save = function () {
            $scope.saving = true;

            ApiUtils
                .subscription
                .channel
                .store(PROJECT_ID, $scope.channel)
                .then(function (response) {
                    toastr.success("Subscription channel created successfully.");
                    $window.location.href = BASE_URL + "/projects/" + PROJECT_ID + "/subscriptions/channels/" + response.data.id;
                }, function (response) {
                    $scope.errors = response.data;
                    toastr.error("Failed to save channel.");
                }).finally(function () {
                    $scope.saving = false;
                });
        };

        /**
         * If option has changed reset errors.
         */
        $scope.$watch("channel.name", function () {
            $scope.errors.name = [];
        });
    });