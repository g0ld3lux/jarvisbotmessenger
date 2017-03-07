angular
    .module("messengerBotApp")
    .controller("SubscriptionChannelAddBroadcastController", function ($scope, $uibModalInstance, $http, toastr, ApiUtils, botId, channelId) {
        /**
         * Determine if responds are loading.
         *
         * @type {boolean}
         */
        $scope.respondsLoading = true;

        /**
         * Initial broadcast.
         *
         * @type {{}}
         */
        $scope.broadcast = {};

        /**
         * Initial save state.
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
         * Responds.
         *
         * @type {Array}
         */
        $scope.responds = [];

        /**
         * Date picker options.
         */
        $scope.datePicker = {
            date: {
                startDate: null
            },
            options: {
                minDate: moment().tz(PROJECT_TIMEZONE),
                timePicker: true,
                singleDatePicker: true,
                timePickerSeconds: false,
                locale: {
                    format: 'MMM D, YYYY, h:mm A'
                },
                eventHandlers: {
                    "apply.daterangepicker": function ($event) {
                        $scope.broadcast.scheduled_at = $event.model.format("YYYY-MM-DD hh:mm:ss");
                    }
                }
            }
        };

        /**
         * Load responds.
         */
        $http.get(BASE_URL + "/api/bot/" + botId + "/respond").then(function (response) {
            $scope.responds = response.data;
        }).finally(function () {
            $scope.respondsLoading = false;
        });

        $scope.save = function () {
            $scope.saving = true;

            var clone = angular.copy($scope.broadcast);

            if ($scope.broadcast.respond) {
                clone.respond = $scope.broadcast.respond.id;
            }

            ApiUtils
                .subscription
                .channel
                .broadcast
                .store(botId, channelId, clone)
                .then(function (response) {
                    toastr.success("Broadcast scheduled successfully.");
                    $uibModalInstance.close(response.data);
                }, function (response) {
                    $scope.errors = response.data;
                }).finally(function () {
                    $scope.saving = false;
                });
        };

        /**
         * Dismiss modal.
         */
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };

        /**
         * Reset errors.
         */
        $scope.$watch('brodcast.name', function () {
            $scope.errors.name = [];
        });

        /**
         * Reset errors.
         */
        $scope.$watch('brodcast.respod', function () {
            $scope.errors.respod = [];
        });

        /**
         * Reset errors.
         */
        $scope.$watch('brodcast.scheduled_at', function () {
            $scope.errors.scheduled_at = [];
        });

        /**
         * Reset errors.
         */
        $scope.$watch('brodcast.timezone', function () {
            $scope.errors.timezone = [];
        });

        /**
         * Reset errors.
         */
        $scope.$watch('brodcast.interval', function () {
            $scope.errors.interval = [];
        });
    });