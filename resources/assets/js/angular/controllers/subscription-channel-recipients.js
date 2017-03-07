angular
    .module("messengerBotApp")
    .controller("SubscriptionChannelRecipientsController", function ($scope, $compile, toastr, ChannelsTableService, RecipientEventsService, RecipientsTableService, GenericTableService, DTOptionsBuilder, DTColumnBuilder, $uibModal) {
        /**
         * Set initial loading state.
         *
         * @type {boolean}
         */
        $scope.recipientsLoading = true;

        /**
         * Initial options.
         */
        $scope.dtOptions = DTOptionsBuilder
            .newOptions()
            .withOption('ajax', {
                url: BASE_URL + "/api/bot/" + BOT_ID + "/subscription/channel/" + SUBSCRIPTION_CHANNEL_ID + "/recipient",
                type: "GET"
            })
            .withOption('createdRow', function(row, data, dataIndex) {
                var $newScope = $scope.$new(true);
                $newScope.row = data;

                return $compile(angular.element(row).contents())($newScope);
            })
            .withDataProp('data')
            .withOption('searching', false)
            .withOption('order', [[2, 'asc']])
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
                .renderWith(RecipientsTableService.picture),
            DTColumnBuilder
                .newColumn("gender")
                .withTitle("")
                .withClass("gender-column")
                .notSortable()
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
                .newColumn("joined_at")
                .withTitle("Joined")
                .withClass("date-column").renderWith(ChannelsTableService.recipient.joinedAt),
            DTColumnBuilder
                .newColumn("join_type")
                .withTitle("Type")
                .renderWith(ChannelsTableService.recipient.joinType),
            DTColumnBuilder
                .newColumn("actions")
                .withTitle("")
                .withClass("actions-column")
                .notSortable()
                .renderWith(ChannelsTableService.recipient.actions)
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
         * On remove success.
         */
        $scope.$on("channel.recipient.delete.success", function () {
            toastr.success("Recipient removed from a channel.");
            $scope.dtInstance.reloadData(null, false);
        });

        /**
         * On remove failure.
         */
        $scope.$on("channel.recipient.delete.fail", function () {
            toastr.error("Failed to remove recipient from a channel.");
        });

        /**
         * Add recipient to a new channel.
         */
        $scope.addRecipients = function () {
            var modalInstance = $uibModal.open({
                templateUrl: "SubscriptionChannelAddRecipientsController.html",
                controller: "SubscriptionChannelAddRecipientsController",
                size: "lg",
                resolve: {
                    botId: function () {
                        return BOT_ID;
                    },
                    channelId: function () {
                        return SUBSCRIPTION_CHANNEL_ID;
                    }
                }
            });

            modalInstance.closed.then(function () {
                $scope.dtInstance.reloadData(null, false);
            });
        };
    });