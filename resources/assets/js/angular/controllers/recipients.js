angular
    .module("messengerBotApp")
    .controller("RecipientsController", function ($scope, $http, toastr, $compile, SweetAlert, RecipientsTableService, GenericTableService, RecipientEventsService, DTColumnBuilder, DTOptionsBuilder) {
        /**
         * Set initial loading state.
         *
         * @type {boolean}
         */
        $scope.recipientsLoading = true;

        /**
         * Set initial bot.
         *
         * @type {{}}
         */
        $scope.bot = {};

        /**
         * Determine if bot is loading.
         *
         * @type {boolean}
         */
        $scope.botLoading = true;

        /**
         * Load active bot.
         */
        $http.get(BASE_URL + "/api/bot/" + PROJECT_ID).then(function (response) {
            $scope.bot = response.data;

            $scope.botLoading = false;

            $scope.$broadcast("bot.loaded", $scope.bot);
        });

        /**
         * Initial options.
         */
        $scope.dtOptions = DTOptionsBuilder
            .newOptions()
            .withOption('ajax', {
                url: BASE_URL + "/api/bot/" + PROJECT_ID + "/recipient",
                type: "GET"
            })
            .withOption('createdRow', function(row, data, dataIndex) {
                var $newScope = $scope.$new(true);
                $newScope.row = data;

                return $compile(angular.element(row).contents())($newScope);
            })
            .withDataProp('data')
            .withOption('order', [[2, 'asc']])
            .withOption('processing', true)
            .withOption('serverSide', true)
            .withPaginationType('full_numbers')
            .withOption("pageLength", 25)
            .withOption("lengthChange", false);

        /**
         * Columns.
         */
        $scope.dtColumns = [
            DTColumnBuilder.newColumn("picture").withOption("searchable", false).withTitle("").withClass("thumb-column").notSortable().renderWith(RecipientsTableService.picture),
            DTColumnBuilder.newColumn("gender").withOption("searchable", false).withTitle("").withClass("gender-column").notSortable().renderWith(RecipientsTableService.gender),
            DTColumnBuilder.newColumn("first_name").withTitle("First name").renderWith(RecipientsTableService.firstName),
            DTColumnBuilder.newColumn("last_name").withTitle("Last name").renderWith(RecipientsTableService.lastName),
            DTColumnBuilder.newColumn("created_at").withOption("searchable", false).withTitle("Created at").withClass("date-column").renderWith(GenericTableService.createdAt),
            DTColumnBuilder.newColumn("chat").withOption("searchable", false).withTitle("").notSortable().withClass("recipient-chat-status").renderWith(RecipientsTableService.chatStatus),
            DTColumnBuilder.newColumn("actions").withOption("searchable", false).withTitle("").withClass("actions-column").notSortable().renderWith(RecipientsTableService.actions)
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
         * Subscribe chat events.
         */
        RecipientEventsService.chat($scope);
    });