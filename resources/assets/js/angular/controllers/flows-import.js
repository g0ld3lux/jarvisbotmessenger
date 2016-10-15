angular
    .module("messengerBotApp")
    .controller("FlowsImportController", function ($scope, $uibModalInstance, Upload, SweetAlert, projectId) {
        /**
         * Set initial exporting state.
         *
         * @type {boolean}
         */
        $scope.importing = false;

        /**
         * Dismiss modal.
         */
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };

        /**
         * Initial errors.
         *
         * @type {{}}
         */
        $scope.errors = {};

        /**
         * Process save.
         */
        $scope.import = function (file) {
            $scope.importing = true;

            $scope.errors = {};

            Upload.upload({
                url: BASE_URL + "/api/project/" + projectId + "/flow/import",
                data: {
                    file: file
                }
            }).then(function () {
                $uibModalInstance.close(true);
            }, function (response) {
                if (response.data.success == undefined) {
                    $scope.errors = response.data;
                } else {
                    SweetAlert.swal({
                        type: "error",
                        title: "Failed to import flows! Try another file.",
                        showCancelButton: false
                    });
                }
            }).finally(function () {
                $scope.importing = false;
            });
        };

        /**
         * Reset errors on change.
         */
        $scope.$watch('file', function () {
            $scope.errors.file = {};
        })
    });