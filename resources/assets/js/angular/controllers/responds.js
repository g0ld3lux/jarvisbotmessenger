angular
    .module("messengerBotApp")
    .controller("RespondsController", function ($scope, $http, toastr, SweetAlert, $window) {
        /**
         * Set initial responds loading state.
         *
         * @type {boolean}
         */
        $scope.respondsLoading = true;

        /**
         * Set initial responds.
         *
         * @type {Array}
         */
        $scope.responds = [];

        /**
         * Load accounts.
         */
        $http.get(BASE_URL + "/api/bot/" + BOT_ID + "/respond").then(function (response) {
            $scope.responds = response.data;
        }, function () {
            toastr.error("Failed to load responds.");
        }).finally(function () {
            $scope.respondsLoading = false;
        });

        /**
         * Delete respond.
         *
         * @param respond
         */
        $scope.deleteRespond = function (respond) {
            SweetAlert.swal({
                title: "Are you sure?",
                text: "Respond will be deleted, you will not be able to restore it!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function (confirm){
                if (confirm) {
                    $http.delete(BASE_URL + "/api/bot/" + BOT_ID + "/respond/" + respond.id).then(function (response) {
                        if (response.data.success) {
                            toastr.success("Respond deleted successfully.");
                            $scope.responds = $scope.responds.filter(function (item) {
                                return item !== respond;
                            });
                        } else {
                            toastr.error('Error occurred when deleting respond.');
                        }
                    }, function () {
                        toastr.error('Error occurred when deleting respond.');
                    });
                }

                SweetAlert.close();
            });
        };

        /**
         * Add new respond.
         */
        $scope.addRespond = function () {
            $window.location.href = BASE_URL + "/bots/" + BOT_ID + "/responds/create";
        };
    });