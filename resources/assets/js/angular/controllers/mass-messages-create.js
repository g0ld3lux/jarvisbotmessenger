angular
    .module("messengerBotApp")
    .controller("MassMessagesCreateController", function ($scope, ApiUtils, $window, toastr, $http) {
        /**
         * Set initial saving state.
         *
         * @type {boolean}
         */
        $scope.saving = false;

        /**
         * Set message.
         *
         * @type {*}
         */
        $scope.message = {};

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
         * Determine if responds are loading.
         *
         * @type {boolean}
         */
        $scope.recipientsLoading = true;

        /**
         * Responds.
         *
         * @type {Array}
         */
        $scope.responds = [];

        /**
         * Recipients.
         *
         * @type {Array}
         */
        $scope.recipients = [];

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
                        $scope.message.scheduled_at = $event.model.format("YYYY-MM-DD hh:mm:ss");
                    }
                }
            }
        };

        /**
         * Load responds.
         */
        $http.get(BASE_URL + "/api/project/" + PROJECT_ID + "/respond").then(function (response) {
            $scope.responds = response.data;
        }).finally(function () {
            $scope.respondsLoading = false;
        });

        /**
         * Load recipients.
         */
        $http.get(BASE_URL + "/api/project/" + PROJECT_ID + "/recipient?all=1").then(function (response) {
            $scope.recipients = response.data;
        }).finally(function () {
            $scope.recipientsLoading = false;
        });

        /**
         * Process save.
         */
        $scope.save = function () {
            $scope.saving = true;

            var clone = angular.copy($scope.message);

            if ($scope.message.responds) {
                clone.responds = _.map($scope.message.responds, function (respond) {
                    return respond.id;
                });
            }

            if ($scope.message.recipients) {
                clone.recipients = _.map($scope.message.recipients, function (recipient) {
                    return recipient.id;
                });
            }

            ApiUtils
                .message
                .store(PROJECT_ID, clone)
                .then(function (response) {
                    toastr.success("Message scheduled successfully.");
                    $window.location.href = BASE_URL + "/projects/" + PROJECT_ID + "/messages/" + response.data.id;
                }, function (response) {
                    $scope.errors = response.data;
                }).finally(function () {
                    $scope.saving = false;
                });
        };

        /**
         * Reset errors.
         */
        $scope.$watch('message.name', function () {
            $scope.errors.name = [];
        });

        /**
         * Reset errors.
         */
        $scope.$watchCollection('message.responds', function () {
            $scope.errors.responds = [];
        });

        /**
         * Reset errors.
         */
        $scope.$watch('message.scheduled_at', function () {
            $scope.errors.scheduled_at = [];
        });

        /**
         * Reset errors.
         */
        $scope.$watch('message.timezone', function () {
            $scope.errors.timezone = [];
        });

        /**
         * Reset errors.
         */
        $scope.$watch('message.interval', function () {
            $scope.errors.interval = [];
        });

        /**
         * Reset errors.
         */
        $scope.$watchCollection('message.recipients', function () {
            $scope.errors.recipients = [];
        });
    });