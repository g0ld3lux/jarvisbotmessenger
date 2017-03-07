angular
    .module("messengerBotApp")
    .controller("SubscriptionsChannelsController", function ($scope, $compile, GenericTableService, ChannelsTableService, DTColumnBuilder, DTOptionsBuilder) {
        /**
         * Set initial loading state.
         *
         * @type {boolean}
         */
        $scope.channelsLoading = true;

        /**
         * Initial options.
         */
        $scope.dtOptions = DTOptionsBuilder
            .newOptions()
            .withOption('ajax', {
                url: BASE_URL + "/api/bot/" + PROJECT_ID + "/subscription/channel",
                type: "GET"
            })
            .withOption('createdRow', function(row, data, dataIndex) {
                var $newScope = $scope.$new(true);
                $newScope.row = data;

                return $compile(angular.element(row).contents())($newScope);
            })
            .withDataProp('data')
            .withOption('order', [[0, 'asc']])
            .withOption('processing', true)
            .withOption('serverSide', true)
            .withPaginationType('full_numbers')
            .withOption("pageLength", 10)
            .withOption("lengthChange", false);

        /**
         * Columns.
         */
        $scope.dtColumns = [
            DTColumnBuilder.newColumn("name").withTitle("Channel"),
            DTColumnBuilder.newColumn("created_at").withOption("searchable", false).withTitle("Created").withClass("date-column").renderWith(GenericTableService.createdAt),
            DTColumnBuilder.newColumn("actions").withOption("searchable", false).withTitle("").withClass("actions-column").notSortable().renderWith(ChannelsTableService.actions)
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
                $scope.channelsLoading = false;
                $scope.$apply();
            });
        };
    });