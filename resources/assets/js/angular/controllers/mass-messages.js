angular
    .module("messengerBotApp")
    .controller("MassMessagesController", function ($scope, $compile, GenericTableService, ChannelsTableService, DTColumnBuilder, DTOptionsBuilder) {
        /**
         * Set initial loading state.
         *
         * @type {boolean}
         */
        $scope.messagesLoading = true;

        /**
         * @param data
         * @param type
         * @param full
         * @param meta
         * @returns {string}
         */
        var renderActions = function (data, type, full, meta) {
            return "<a message-href=\"row\" class=\"btn btn-primary\" uib-tooltip=\"Details\" tooltip-trigger=\"mouseenter\"><i class=\"fa fa-arrow-right\"></i></a>";
        };

        /**
         * Initial options.
         */
        $scope.dtOptions = DTOptionsBuilder
            .newOptions()
            .withOption('ajax', {
                url: BASE_URL + "/api/bot/" + BOT_ID + "/message",
                type: "GET"
            })
            .withOption('createdRow', function(row, data, dataIndex) {
                var $newScope = $scope.$new(true);
                $newScope.row = data;

                return $compile(angular.element(row).contents())($newScope);
            })
            .withDataProp('data')
            .withOption('order', [[1, 'desc']])
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
                .withOption("searchable", false)
                .withTitle("Scheduled")
                .withClass("date-column")
                .renderWith(GenericTableService.scheduledAt),
            DTColumnBuilder
                .newColumn("finished_at")
                .withOption("searchable", false)
                .withTitle("Finished")
                .withClass("date-column")
                .renderWith(GenericTableService.finishedAt),
            DTColumnBuilder
                .newColumn("created_at")
                .withOption("searchable", false)
                .withTitle("Created")
                .withClass("date-column")
                .renderWith(GenericTableService.createdAt),
            DTColumnBuilder
                .newColumn("actions")
                .withOption("searchable", false)
                .withTitle("").withClass("actions-column")
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
                $scope.messagesLoading = false;
                $scope.$apply();
            });
        };
    });