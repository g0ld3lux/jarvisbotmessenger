angular
    .module("messengerBotApp")
    .controller("RecipientDetailsController", function ($scope, $compile, toastr, RecipientEventsService, ApiUtils, SweetAlert) {
        /**
         * Initial variables.
         *
         * @type {Array}
         */
        $scope.recipientVariables = [];

        /**
         * Refresh recipient data from server.
         *
         * @param recipient
         */
        $scope.refreshData = function (recipient) {
            SweetAlert.swal({
                title: "Are you sure?",
                text: "Recipient data will be fetched from facebook servers and replaced!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, refresh it!",
                closeOnConfirm: false
            }, function (confirm){
                if (confirm) {
                    ApiUtils.recipient.refresh(recipient.project_id, recipient.id).then(function (response) {
                        $scope.$emit("recipient.refresh.success", response.data);
                    }, function (response) {
                        $scope.$emit("recipient.refresh.fail", response);
                    });
                }

                SweetAlert.close();
            });
        };

        /**
         * Change variables.
         */
        $scope.$on("recipient.loaded", function ($event, recipient) {
            $scope.recipientVariables = recipient.variables;
        });

        /**
         * Update recipient data.
         */
        $scope.$on("recipient.refresh.success", function ($event, recipient) {
            $scope.recipientVariables = recipient.variables;
        });
    });