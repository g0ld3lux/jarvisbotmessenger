angular
    .module("messengerBotApp")
    .controller("SubscriptionChannelDetailsController", function ($scope, $http, toastr, ApiUtils, SweetAlert, $window) {
        /**
         * Copied instance.
         *
         * @type {{}}
         */
        $scope.channelCopy = {};

        /**
         * Set edit mode.
         *
         * @type {boolean}
         */
        $scope.editMode = false;

        /**
         * Saving state.
         *
         * @type {boolean}
         */
        $scope.saving = false;

        /**
         * Initial errors.
         *
         * @type {{}}
         */
        $scope.errors = {};

        /**
         * Enable edit mode.
         */
        $scope.enableEdit = function () {
            $scope.errors = {};
            $scope.channelCopy = angular.copy($scope.channel);
            $scope.editMode = true;
        };

        /**
         * Disable edit mode.
         */
        $scope.disableEdit = function () {
            $scope.editMode = false;
            if (!angular.equals($scope.channel, $scope.channelCopy)) {
                toastr.warning("Changes were canceled.");
            }
        };

        /**
         * Save channel.
         */
        $scope.save = function () {
            $scope.saving = true;

            ApiUtils
                .subscription
                .channel
                .update(PROJECT_ID, SUBSCRIPTION_CHANNEL_ID, $scope.channelCopy)
                .then(function (response) {
                    $scope.$emit("channel.update.success", response.data);
                    $scope.editMode = false;
                }, function (response) {
                    $scope.errors = response.data;
                    toastr.error("Failed to update channel details.");
                })
                .finally(function () {
                    $scope.saving = false;
                });
        };

        /**
         * Determine if channel can be saved.
         *
         * @returns {boolean}
         */
        $scope.canSave = function () {
            return !angular.equals($scope.channel, $scope.channelCopy);
        };

        /**
         * Delete channel.
         */
        $scope.delete = function () {
            SweetAlert.swal({
                title: "Are you sure?",
                text: "Channel and all its data will be removed!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, remove it!",
                closeOnConfirm: false
            }, function (confirm){
                if (confirm) {
                    ApiUtils.subscription.channel.delete(PROJECT_ID, SUBSCRIPTION_CHANNEL_ID).then(function () {
                        toastr.success("Channel deleted successfully.");
                        $window.location.href = BASE_URL + "/projects/" + PROJECT_ID + "/subscriptions/channels";
                    }, function () {
                        toastr.error("Failed to delete channel.");
                    });
                }

                SweetAlert.close();
            });
        }
    });