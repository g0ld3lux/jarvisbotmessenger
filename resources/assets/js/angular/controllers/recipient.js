angular
    .module("messengerBotApp")
    .controller("RecipientController", function ($scope, $http, toastr, RecipientEventsService) {
        /**
         * Set initial loading state.
         *
         * @type {boolean}
         */
        $scope.recipientLoading = true;

        /**
         * Initial recipient.
         *
         * @type {{}}
         */
        $scope.recipient = {};

        /**
         * Load bot.
         */
        $http.get(BASE_URL + "/api/bot/" + BOT_ID + "/recipient/" + RECIPIENT_ID).then(function (response) {
            $scope.recipient = response.data;

            $scope.$broadcast("recipient.loaded", $scope.recipient);
        }).finally(function () {
            $scope.recipientLoading = false;
        });

        /**
         * Update recipient data.
         */
        $scope.$on("recipient.refresh.success", function ($event, recipient) {
            toastr.success("Recipient data updated.");
            $scope.recipient = recipient;
        });

        /**
         * Subscribe chat events.
         */
        RecipientEventsService.chat($scope);
    });