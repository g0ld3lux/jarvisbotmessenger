angular
    .module("messengerBotApp")
    .controller("MassMessageController", function ($scope, ApiUtils, SweetAlert, toastr, $window) {
        /**
         * Set initial loading state.
         *
         * @type {boolean}
         */
        $scope.messageLoading = true;

        /**
         * Initial message.
         *
         * @type {{}}
         */
        $scope.message = {};

        /**
         * Load broadcast.
         */
        ApiUtils
            .message
            .show(PROJECT_ID, MESSAGE_ID)
            .then(function (response) {
                $scope.message = response.data;
            })
            .finally(function () {
                $scope.messageLoading = false;
            });

        /**
         * Delete broadcast.
         */
        $scope.delete = function () {
            SweetAlert.swal({
                title: "Are you sure?",
                text: "Message and all its data will be removed!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, remove it!",
                closeOnConfirm: false
            }, function (confirm){
                if (confirm) {
                    ApiUtils
                        .message
                        .delete(PROJECT_ID, $scope.message.id)
                        .then(function () {
                            toastr.success("Message deleted successfully.");
                            $window.location.href = BASE_URL + "/projects/" + PROJECT_ID + "/messages";
                        }, function () {
                            toastr.error("Failed to delete message.");
                        });
                }

                SweetAlert.close();
            });
        }
    });