angular
    .module("messengerBotApp")
    .controller("SubscriptionChannelBroadcastsController", function ($scope, $compile, toastr, ChannelsTableService, GenericTableService, DTOptionsBuilder, DTColumnBuilder, $uibModal) {
        /**
         * Set initial loading state.
         *
         * @type {boolean}
         */
        $scope.broadcastsLoading = true;

        /**
         * @param data
         * @param type
         * @param full
         * @param meta
         * @returns {string}
         */
        var renderActions = function (data, type, full, meta) {
            return "<a broadcast-href=\"row\" class=\"btn btn-primary\" uib-tooltip=\"Details\" tooltip-trigger=\"mouseenter\"><i class=\"fa fa-arrow-right\"></i></a>";
        };

        /**
         * Initial options.
         */
        $scope.dtOptions = DTOptionsBuilder
            .newOptions()
            .withOption('ajax', {
                url: BASE_URL + "/api/bot/" + PROJECT_ID + "/subscription/channel/" + SUBSCRIPTION_CHANNEL_ID + "/broadcast",
                type: "GET"
            })
            .withOption('createdRow', function(row, data, dataIndex) {
                var $newScope = $scope.$new(true);
                $newScope.row = data;

                return $compile(angular.element(row).contents())($newScope);
            })
            .withDataProp('data')
            .withOption('searching', false)
            .withOption('order', [[3, 'desc']])
            .withOption('processing', true)
            .withOption('serverSide', true)
            .withPaginationType('full_numbers')
            .withOption("pageLength", 10)
            .withOption("lengthChange", false);

        /**
         * Columns.
         */
        $scope.dtColumns = [
            DTColumnBuilder
                .newColumn("name")
                .withTitle("Name"),
            DTColumnBuilder
                .newColumn("scheduled_at")
                .withTitle("Scheduled")
                .withClass("date-column")
                .renderWith(GenericTableService.scheduledAt),
            DTColumnBuilder
                .newColumn("finished_at")
                .withTitle("Finished")
                .renderWith(GenericTableService.finishedAt),
            DTColumnBuilder
                .newColumn("created_at")
                .withTitle("Created")
                .renderWith(GenericTableService.createdAt),
            DTColumnBuilder
                .newColumn("actions")
                .withTitle("")
                .withClass("actions-column")
                .notSortable()
                .renderWith(renderActions)
        ];

        /**
         * Initial table instance.
         *
         * @type {{}}
         */
        $scope.dtInstance = {};

        /**
         * Init events on data table instance.
         *
         * @param dtInstance
         */
        $scope.dtInstanceCallback = function (dtInstance) {
            $scope.dtInstance = dtInstance;

            $scope.dtInstance.DataTable.on("xhr", function () {
                $scope.broadcastsLoading = false;
                $scope.$apply();
            });
        };

        /**
         * Broadcast new content.
         */
        $scope.addBroadcast = function () {
            var modalInstance = $uibModal.open({
                templateUrl: "SubscriptionChannelAddBroadcastController.html",
                controller: "SubscriptionChannelAddBroadcastController",
                resolve: {
                    botId: function () {
                        return PROJECT_ID;
                    },
                    channelId: function () {
                        return SUBSCRIPTION_CHANNEL_ID;
                    }
                }
            });

            modalInstance.result.then(function (broadcast) {
                if (broadcast) {
                    $scope.dtInstance.reloadData(null, false);
                }
            });
        };
    });