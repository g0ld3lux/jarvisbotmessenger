angular
    .module("messengerBotApp")
    .controller("RecipientHistoryController", function ($scope, $compile, RecipientsTableService, GenericTableService, DTOptionsBuilder, DTColumnBuilder, $uibModal) {
        /**
         * Set initial loading state.
         *
         * @type {boolean}
         */
        $scope.historyLoading = true;

        /**
         * Initial options.
         */
        $scope.dtOptions = DTOptionsBuilder
            .newOptions()
            .withOption('ajax', {
                url: BASE_URL + "/api/project/" + PROJECT_ID + "/recipient/" + RECIPIENT_ID + "/history",
                type: "GET"
            })
            .withOption('createdRow', function(row, data, dataIndex) {
                var $newScope = $scope.$new(true);
                $newScope.row = data;

                return $compile(angular.element(row).contents())($newScope);
            })
            .withDataProp('data')
            .withOption('searching', false)
            .withOption('order', [[2, 'desc']])
            .withOption('processing', true)
            .withOption('serverSide', true)
            .withPaginationType('full_numbers')
            .withOption("pageLength", 10)
            .withOption("lengthChange", false);

        /**
         * Columns.
         */
        $scope.dtColumns = [
            DTColumnBuilder.newColumn("message").withTitle("Message").notSortable(),
            DTColumnBuilder.newColumn("respond").withTitle("Respond").notSortable().notSortable().renderWith(RecipientsTableService.history.respond),
            DTColumnBuilder.newColumn("created_at").withTitle("Date").withClass("date-column").notSortable().renderWith(GenericTableService.createdAt)
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
                $scope.historyLoading = false;
                $scope.$apply();
            });
        };
    });