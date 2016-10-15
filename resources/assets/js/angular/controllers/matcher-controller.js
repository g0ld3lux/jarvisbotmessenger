angular
    .module("messengerBotApp")
    .controller("MatcherController", function ($scope, $uibModalInstance, $http, matcher) {
        /**
         * Set initial validation state.
         *
         * @type {boolean}
         */
        $scope.validating = false;

        /**
         * Set initial plain params.
         *
         * @type {{}}
         */
        matcher.p = {};

        /**
         * Set plain params.
         */
        angular.forEach(matcher.params, function (param) {
            matcher.p[param.key] = param.value;
        });

        /**
         * Set initial matcher.
         *
         * @type {{}}
         */
        $scope.matcher = matcher;

        /**
         * Initial errors.
         *
         * @type {{}}
         */
        $scope.errors = {};

        /**
         * Save matcher.
         */
        $scope.save = function () {
            $scope.validating = true;

            var data = $scope.matcher.p;
            data.type = $scope.matcher.type;

            $http
                .post(BASE_URL + "/api/validate/matcher", data)
                .then(function () {
                    $scope.validating = false;

                    $scope.matcher.params = [];

                    angular.forEach($scope.matcher.p, function (param, i) {
                        $scope.matcher.params.push({ key: i, value: param });
                    });

                    $uibModalInstance.close($scope.matcher);
                }, function (response) {
                    $scope.errors = response.data;
                    $scope.validating = false;
                });
        };

        /**
         * Dismiss modal.
         */
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };

        /**
         * If text has changed reset errors.
         */
        $scope.$watch("matcher.p.text", function () {
            $scope.errors.text = [];
        });

        /**
         * If case has changed reset errors.
         */
        $scope.$watch("matcher.p.case", function () {
            $scope.errors.case = [];
        });

        /**
         * If pattern has changed reset errors.
         */
        $scope.$watch("matcher.p.pattern", function () {
            $scope.errors.pattern = [];
        });

        /**
         * If pattern has changed reset errors.
         */
        $scope.$watch("matcher.p.sensitivity", function () {
            $scope.errors.sensitivity = [];
        });

        /**
         * If type has changed reset params and errors.
         */
        $scope.$watch("matcher.type", function (newValue, oldValue) {
            if (!angular.equals(newValue, oldValue)) {
                $scope.matcher.p = {};
                $scope.errors = {};
            }
        });
    });