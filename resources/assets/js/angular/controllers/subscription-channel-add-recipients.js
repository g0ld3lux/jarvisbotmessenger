angular
    .module("messengerBotApp")
    .controller("SubscriptionChannelAddRecipientsController", function ($scope, $uibModalInstance, DTOptionsBuilder, DTColumnBuilder, RecipientsTableService, ApiUtils, $compile, toastr, botId, channelId) {
        /**
         * @type {boolean}
         */
        $scope.adding = false;

        /**
         * @type {boolean}
         */
        $scope.recipientsLoading = true;

        /**
         * @type {Array}
         */
        $scope.current = [];

        /**
         * @param data
         * @param type
         * @param full
         * @param meta
         * @returns {string}
         */
        var renderActions = function (data, type, full, meta) {
            return "<button ng-click=\"add(row.id)\" class=\"btn btn-success\" uib-tooltip=\"Add to a channel\" tooltip-trigger=\"mouseenter\"><i class=\"fa fa-plus\"></i></button>";
        };

        /**
         * Initial options.
         */
        $scope.dtOptions = DTOptionsBuilder
            .newOptions()
            .withOption('ajax', {
                url: BASE_URL + "/api/bot/" + botId + "/subscription/channel/" + channelId + "/recipient/missing",
                type: "GET"
            })
            .withOption('createdRow', function(row, data, dataIndex) {
                var $newScope = $scope.$new(true);
                $newScope.row = data;
                $newScope.add = $scope.add;

                return $compile(angular.element(row).contents())($newScope);
            })
            .withDataProp('data')
            .withOption('order', [[2, 'asc']])
            .withOption('processing', true)
            .withOption('serverSide', true)
            .withPaginationType('full_numbers')
            .withOption("pageLength", 5)
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
                .withOption("searchable", false)
                .renderWith(RecipientsTableService.picture),
            DTColumnBuilder
                .newColumn("gender")
                .withTitle("")
                .withClass("gender-column")
                .notSortable()
                .withOption("searchable", false)
                .renderWith(RecipientsTableService.gender),
            DTColumnBuilder
                .newColumn("first_name")
                .withTitle("First name")
                .renderWith(RecipientsTableService.firstName),
            DTColumnBuilder
                .newColumn("last_name")
                .withTitle("Last name")
                .renderWith(RecipientsTableService.lastName),
            DTColumnBuilder
                .newColumn("actions")
                .withTitle("")
                .withClass("actions-column")
                .notSortable()
                .withOption("searchable", false)
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
                $scope.recipientsLoading = false;
                $scope.$apply();
            });
        };

        /**
         * Add new recipient.
         *
         * @param id
         */
        $scope.add = function (id) {
            ApiUtils
                .subscription
                .channel
                .recipient
                .store(botId, channelId, [{ id: id, type: 'manual' }])
                .then(function () {
                    $scope.dtInstance.reloadData(null, false);
                    toastr.success("Recipient successfully added to a channel.");
                }, function () {
                    toastr.error("Failed to add recipient to a channel.");
                });
        };

        /**
         * Dismiss modal.
         */
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    });