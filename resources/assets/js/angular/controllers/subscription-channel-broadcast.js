angular
    .module("messengerBotApp")
    .controller("SubscriptionChannelBroadcastController", function ($scope, ApiUtils, SweetAlert, toastr, $window) {
        /**
         * Set initial loading state.
         *
         * @type {boolean}
         */
        $scope.broadcastLoading = true;

        /**
         * Initial broadcast.
         *
         * @type {{}}
         */
        $scope.broadcast = {};

        /**
         * Load broadcast.
         */
        ApiUtils
            .subscription
            .channel
            .broadcast
            .show(PROJECT_ID, SUBSCRIPTION_CHANNEL_ID, BROADCAST_ID)
            .then(function (response) {
                $scope.broadcast = response.data;
            })
            .finally(function () {
                $scope.broadcastLoading = false;
            });

        /**
         * Delete broadcast.
         */
        $scope.delete = function () {
            SweetAlert.swal({
                title: "Are you sure?",
                text: "Broadcast and all its data will be removed!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, remove it!",
                closeOnConfirm: false
            }, function (confirm){
                if (confirm) {
                    ApiUtils
                        .subscription
                        .channel
                        .broadcast
                        .delete(PROJECT_ID, SUBSCRIPTION_CHANNEL_ID, $scope.broadcast.id)
                        .then(function () {
                            toastr.success("Broadcast deleted successfully.");
                            $window.location.href = BASE_URL + "/bots/" + PROJECT_ID + "/subscriptions/channels/" + SUBSCRIPTION_CHANNEL_ID;
                        }, function () {
                            toastr.error("Failed to delete broadcast.");
                        });
                }

                SweetAlert.close();
            });
        }
    });