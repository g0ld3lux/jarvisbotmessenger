angular
    .module("messengerBotApp")
    .controller("SubscriptionChannelController", function ($scope, $http, toastr) {
        /**
         * Set initial loading state.
         *
         * @type {boolean}
         */
        $scope.channelLoading = true;

        /**
         * Initial recipient.
         *
         * @type {{}}
         */
        $scope.channel = {};

        /**
         * Load bot.
         */
        $http.get(BASE_URL + "/api/bot/" + PROJECT_ID + "/subscription/channel/" + SUBSCRIPTION_CHANNEL_ID).then(function (response) {
            $scope.channel = response.data;

            $scope.$broadcast("channel.loaded", $scope.channel);
        }).finally(function () {
            $scope.channelLoading = false;
        });

        /**
         * Update data.
         */
        $scope.$on("channel.update.success", function ($event, channel) {
            toastr.success("Channel details updated successfully.");
            $scope.channel = channel;
        });
    });