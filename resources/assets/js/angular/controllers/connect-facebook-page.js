angular
    .module("messengerBotApp")
    .controller("ConnectFacebookPageController", function ($scope, $uibModalInstance, pages) {
        /**
         * Set initial pages.
         *
         * @type {Array}
         */
        $scope.pages = pages;

        /**
         * Select page and close modal.
         *
         * @param page
         */
        $scope.select = function (page) {
            $uibModalInstance.close(page);
        };

        /**
         * Dismiss modal.
         */
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    });