angular
    .module("messengerBotApp")
    .controller("TemplatesModalController", function ($scope, toastr, $uibModal) {

         /**
         * Show Template modal.
         */
        $scope.openModalTemplates = function () {
            var modalInstance = $uibModal.open({
                templateUrl: "TemplatesClonerController.html",
                controller: "TemplatesClonerController",
                resolve: {
                    botId: function () {
                        return BOT_ID;
                    }
                }
            });
            modalInstance.result.then(function (result) {
                if (result) {
                    toastr.success("Fetching All Templates...");
                }
            });
        };
});