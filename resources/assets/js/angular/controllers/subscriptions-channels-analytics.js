angular
    .module("messengerBotApp")
    .controller("SubscriptionsChannelsAnalyticsController", function ($scope, ApiUtils) {
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
            broadcast_messages_sent: "Total broadcasted messages"
        };

        /**
         * Update analytics chart.
         *
         * @param start
         * @param end
         */
        var updateAnalytics = function (start, end) {
            $scope.analyticsLoading = true;

            ApiUtils.project.analytics(
                PROJECT_ID,
                _.map(fields, function(value, key) {
                    return key;
                }),
                start.format("YYYY-MM-DD"),
                end.format("YYYY-MM-DD")
            ).then(function (response) {
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
                        updateAnalytics($event.model.startDate, $event.model.endDate);
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
                display: true
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

        updateAnalytics($scope.datePicker.date.startDate, $scope.datePicker.date.endDate);
    });