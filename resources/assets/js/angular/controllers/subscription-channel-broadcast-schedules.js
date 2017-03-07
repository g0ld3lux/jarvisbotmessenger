angular
    .module("messengerBotApp")
    .controller("SubscriptionChannelBroadcastSchedulesController", function ($scope, $compile, toastr, SubscriptionChannelBroadcastSchedulesTableService, GenericTableService, DTOptionsBuilder, DTColumnBuilder) {
        /**
         * Set initial loading state.
         *
         * @type {boolean}
         */
        $scope.schedulesLoading = true;

        /**
         * Initial options.
         */
        $scope.dtOptions = DTOptionsBuilder
            .newOptions()
            .withOption('ajax', {
                url: BASE_URL + "/api/bot/" + BOT_ID + "/subscription/channel/" + SUBSCRIPTION_CHANNEL_ID + "/broadcast/" + BROADCAST_ID + "/schedule",
                type: "GET"
            })
            .withOption('createdRow', function(row, data, dataIndex) {
                var $newScope = $scope.$new(true);
                $newScope.row = data;

                return $compile(angular.element(row).contents())($newScope);
            })
            .withDataProp('data')
            .withOption('searching', false)
            .withOption('order', [[3, 'asc']])
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
                .newColumn("picture")
                .withTitle("")
                .withClass("thumb-column")
                .notSortable()
                .renderWith(SubscriptionChannelBroadcastSchedulesTableService.recipient.picture),
            DTColumnBuilder
                .newColumn("display_name")
                .withTitle("Recipient")
                .notSortable()
                .renderWith(SubscriptionChannelBroadcastSchedulesTableService.recipient.displayName),
            DTColumnBuilder
                .newColumn("timezone")
                .withTitle("Timezone")
                .notSortable()
                .renderWith(SubscriptionChannelBroadcastSchedulesTableService.recipient.timezone),
            DTColumnBuilder
                .newColumn("scheduled_at")
                .withTitle("Scheduled")
                .withClass("date-column")
                .renderWith(SubscriptionChannelBroadcastSchedulesTableService.scheduledAt),
            DTColumnBuilder
                .newColumn("sent_at")
                .withTitle("Sent")
                .withClass("date-column")
                .renderWith(SubscriptionChannelBroadcastSchedulesTableService.sentAt)
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
                $scope.schedulesLoading = false;
                $scope.$apply();
            });
        };
    });