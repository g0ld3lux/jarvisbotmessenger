angular
    .module("messengerBotApp")
    .controller("FlowController", function ($scope, $uibModalInstance, $uibModal, $http, toastr, bot, flow) {
        /**
         * Set initial saving state.
         *
         * @type {boolean}
         */
        $scope.saving = false;

        /**
         * Set initial responds.
         */
        if (!flow.responds) {
            flow.responds = [];
        }

        /**
         * Set initial matchers.
         */
        if (!flow.matchers) {
            flow.matchers = [];
        }

        /**
         * Set initial flow.
         *
         * @type {{}}
         */
        $scope.flow = flow;

        /**
         * Set initial bot.
         *
         * @type {{}}
         */
        $scope.bot = bot;

        /**
         * Initial errors.
         *
         * @type {{}}
         */
        $scope.errors = {};

        /**
         * Determine if responds are loading.
         *
         * @type {boolean}
         */
        $scope.respondsLoading = true;

        /**
         * Store deleted matchers here.
         *
         * @type {Array}
         */
        var deletedMatchers = [];

        /**
         * Determine saved matchers count.
         *
         * @type {number}
         */
        var matchersToProcess = 0;

        /**
         * Show matcher modal and process it.
         *
         * @param matcher
         */
        var matcherModal = function (matcher) {
            var modalInstance = $uibModal.open({
                templateUrl: "MatcherController.html",
                controller: "MatcherController",
                resolve: {
                    matcher: function () {
                        var clone = angular.copy(matcher);

                        clone.p = {};

                        if (clone.params) {
                            angular.forEach(clone.params, function (param) {
                                clone.p[param.key] = param.value;
                            });
                        }

                        return clone;
                    }
                }
            });

            modalInstance.result.then(function (updatedMatcher) {
                updatedMatcher.params = [];

                angular.forEach(updatedMatcher.p, function (param, i) {
                    updatedMatcher.params.push({ key: i, value: param });
                });

                if (!updatedMatcher.hasOwnProperty("id")) {
                    updatedMatcher.id = null;
                    $scope.flow.matchers.push(updatedMatcher);
                } else {
                    angular.forEach($scope.flow.matchers, function (value, i) {
                        if (value.id == updatedMatcher.id) {
                            $scope.flow.matchers[i] = updatedMatcher;
                        }
                    });
                }
            });
        };

        /**
         * Delete matcher.
         *
         * @param flow
         * @param matcher
         */
        var deleteMatcher = function (flow, matcher) {
            if (matcher.id) {
                $http
                    .delete(BASE_URL + "/api/bot/" + bot.id + "/flow/" + flow.id + "/matcher/" + matcher.id)
                    .then(function () {
                        $scope.$broadcast("matcher.processed");
                    }, function () {
                        $scope.$broadcast("matcher.processed");
                        toastr.error("Failed to remove phrase.");
                    });
            } else {
                $scope.$broadcast("matcher.processed");
            }
        };

        /**
         * Save matcher.
         *
         * @param flow
         * @param matcher
         */
        var saveMatcher = function (flow, matcher) {
            var url = BASE_URL + "/api/bot/" + bot.id + "/flow/" + flow.id + "/matcher";

            if (matcher.id) {
                url += "/" + matcher.id;
            }

            var data = { type: matcher.type };

            angular.forEach(matcher.params, function (param) {
                data[param.key] = param.value;
            });

            (matcher.id ? $http.put(url, data) : $http.post(url, data)).then(function () {
                $scope.$broadcast("matcher.processed");
            }, function () {
                toastr.error("Failed to save phrase.");
                $scope.$broadcast("matcher.processed");
            });
        };

        /**
         * Load responds.
         */
        $http.get(BASE_URL + "/api/bot/" + bot.id + "/respond").then(function (response) {
            $scope.responds = response.data;
            $scope.respondsLoading = false;
        });

        /**
         * Save flow.
         */
        $scope.save = function () {
            $scope.saving = true;

            var url = BASE_URL + "/api/bot/" + bot.id + "/flow";

            if ($scope.flow.id) {
                url += "/" + $scope.flow.id;
            }

            matchersToProcess = $scope.flow.matchers.length;

            ($scope.flow.id ? $http.put(url, $scope.flow) : $http.post(url, $scope.flow)).then(function (response) {
                $scope.flow.id = response.data.id;

                angular.forEach(deletedMatchers, function (matcher) {
                    $scope.flow.matchers = $scope.flow.matchers.filter(function (item) {
                        return item !== matcher;
                    });

                    deleteMatcher($scope.flow, matcher);
                });

                angular.forEach($scope.flow.matchers, function (matcher) {
                    saveMatcher($scope.flow, matcher);
                });

                if (matchersToProcess <= 0) {
                    $scope.$broadcast("matcher.processed");
                }
            }, function (response) {
                $scope.saving = false;
                $scope.errors = response.data;
            });
        };

        /**
         * Dismiss modal.
         */
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };

        /**
         * Schedule matcher for deletion.
         *
         * @param matcher
         */
        $scope.deleteMatcher = function (matcher) {
            if (!$scope.isMatcherDeleted(matcher)) {
                deletedMatchers.push(matcher);
            }
        };

        /**
         * Determine if matcher scheduled for deletion.
         *
         * @param matcher
         * @returns {boolean}
         */
        $scope.isMatcherDeleted = function (matcher) {
            return deletedMatchers.indexOf(matcher) > -1;
        };

        /**
         * Restore matcher.
         *
         * @param matcher
         */
        $scope.restoreMatcher = function (matcher) {
            if ($scope.isMatcherDeleted(matcher)) {
                deletedMatchers.splice(deletedMatchers.indexOf(matcher), 1);
            }
        };

        /**
         * Edit matcher modal.
         *
         * @param matcher
         */
        $scope.editMatcher = function (matcher) {
            matcherModal(matcher);
        };

        /**
         * New matcher modal.
         */
        $scope.addMatcher = function () {
            matcherModal({});
        };

        /**
         * If title has changed reset errors.
         */
        $scope.$watch("title", function () {
            $scope.errors.title = [];
        });

        /**
         * All matchers has been processed, close modal.
         */
        $scope.$on("matcher.processed", function () {
            matchersToProcess--;

            if (matchersToProcess <= 0) {
                $scope.saving = false;
                $uibModalInstance.close($scope.flow);
            }
        })
    });