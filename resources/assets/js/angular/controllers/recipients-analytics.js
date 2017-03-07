angular
    .module("messengerBotApp")
    .controller("RecipientsAnalyticsController", function ($scope, $http) {
        /**
         * Set initial loading state.
         *
         * @type {boolean}
         */
        $scope.analyticsLoading = true;

        /**
         * Analytics fields.
         *
         * @type {{}}
         */
        var fields = {
            recipients: "New recipients"
        };

        /**
         * Update analytics chart.
         *
         * @param bot
         * @param start
         * @param end
         */
        var updateAnalytics = function (bot, start, end) {
            $scope.analyticsLoading = true;

            $http
                .get(BASE_URL + "/api/bot/" + bot.id + "/analytics", {
                    params: {
                        "fields[]": _.map(fields, function(value, key) {
                            return key;
                        }),
                        start: start.format("YYYY-MM-DD"),
                        end: end.format("YYYY-MM-DD")
                    }
                })
                .then(function (response) {
                    $scope.data = [];
                    $scope.labels = [];

                    angular.forEach(response.data, function (value, date) {
                        $scope.labels.push(date);
                    });

                    angular.forEach(fields, function (label, field) {
                        var dataSet = [];

                        angular.forEach(response.data, function (data, date) {
                            dataSet.push(data[field]);
                        });

                        $scope.data.push(dataSet);
                    });
                }).finally(function () {
                    $scope.analyticsLoading = false;
                });
        };

        /**
         * Date range picker options
         *
         * @type {{}}
         */
        $scope.datePicker = {
            options: {
                autoApply: true,
                opens: "left",
                eventHandlers: {
                    "apply.daterangepicker": function ($event) {
                        updateAnalytics($scope.bot, $event.model.startDate, $event.model.endDate);
                    }
                }
            },
            date: {
                startDate: moment().add(-30, "days"),
                endDate: moment()
            }
        };

        /**
         * Chart options
         *
         * @type {{}}
         */
        $scope.options = {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    stacked: true,
                    ticks: {
                        autoSkip: true,
                        maxRotation: 0,
                        maxTicksLimit: 5
                    }
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        };

        /**
         * Initial labels.
         *
         * @type {Array}
         */
        $scope.labels = [];

        /**
         * Initial data.
         *
         * @type {Array}
         */
        $scope.data = [];

        /**
         * Chart colors.
         *
         * @type {Array}
         */
        $scope.colors = ["#45b7cd"];

        /**
         * Initial series.
         *
         * @type {Array}
         */
        $scope.series = _.map(fields, function (value, key) {
            return value;
        });

        /**
         * Load analytics data.
         */
        $scope.$on("bot.loaded", function ($event, bot) {
            updateAnalytics(bot, $scope.datePicker.date.startDate, $scope.datePicker.date.endDate);
        });
    });