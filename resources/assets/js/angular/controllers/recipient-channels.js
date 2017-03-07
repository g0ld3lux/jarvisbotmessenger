angular
    .module("messengerBotApp")
    .controller("RecipientChannelsController", function ($scope, $compile, toastr, RecipientEventsService, RecipientsTableService, GenericTableService, DTOptionsBuilder, DTColumnBuilder, $uibModal) {
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
                url: BASE_URL + "/api/bot/" + PROJECT_ID + "/recipient/" + RECIPIENT_ID + "/channel",
                type: "GET"
            })
            .withOption('createdRow', function(row, data, dataIndex) {
                var $newScope = $scope.$new(true);
                $newScope.row = data;

                return $compile(angular.element(row).contents())($newScope);
            })
            .withDataProp('data')
            .withOption('searching', false)
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
            DTColumnBuilder.newColumn("name").withTitle("Channel").notSortable(),
            DTColumnBuilder.newColumn("created_at").withTitle("Added").notSortable().withClass("date-column").renderWith(GenericTableService.createdAt),
            DTColumnBuilder.newColumn("type").withTitle("Type").notSortable(),
            DTColumnBuilder.newColumn("actions").withOption("searchable", false).withTitle("").withClass("actions-column").notSortable().renderWith(RecipientsTableService.channel.actions)
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

        /**
         * Subscribe chat events.
         */
        RecipientEventsService.chat($scope);

        /**
         * On remove success.
         */
        $scope.$on("recipient.channel.delete.success", function () {
            toastr.success("Recipient removed from a subscribed channel.");
            $scope.dtInstance.reloadData(null, false);
        });

        /**
         * On remove failure.
         */
        $scope.$on("recipient.channel.delete.fail", function () {
            toastr.error("Failed to remove recipient from a channel.");
        });

        /**
         * Add recipient to a new channel.
         */
        $scope.addToChannel = function () {
            var modalInstance = $uibModal.open({
                templateUrl: "RecipientAddToChannelController.html",
                controller: "RecipientAddToChannelController",
                resolve: {
                    botId: function () {
                        return PROJECT_ID;
                    },
                    recipientId: function () {
                        return RECIPIENT_ID;
                    }
                }
            });

            modalInstance.result.then(function (channels) {
                if (channels) {
                    toastr.success("Recipient added to a channel.");
                    $scope.dtInstance.reloadData(null, false);
                }
            });
        };
    });