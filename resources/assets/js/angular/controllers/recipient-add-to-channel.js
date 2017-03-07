angular
    .module("messengerBotApp")
    .controller("RecipientAddToChannelController", function ($scope, toastr, $uibModalInstance, ApiUtils, $http, botId, recipientId) {
        /**
         * Set initial saving state.
         *
         * @type {boolean}
         */
        $scope.saving = false;

        /**
         * Set initial loading state.
         *
         * @type {boolean}
         */
        $scope.loading = true;

        /**
         * Set initial channels.
         *
         * @type {{}}
         */
        $scope.channels = [];

        /**
         * Initial relations.
         *
         * @type {{channels: Array}}
         */
        $scope.relation = { channels: [] };

        /**
         * Initial errors.
         *
         * @type {{}}
         */
        $scope.errors = {};

        /**
         * Load all channels.
         */
        ApiUtils.recipient.channel.index(botId, recipientId).then(function (response) {
            var recipientChannels = _.map(response.data, function (value) {
                return value.id;
            });

            $http.get(BASE_URL + "/api/bot/" + botId + "/subscription/channel", { params: { all: true } }).then(function (allResponse) {
                $scope.channels = allResponse.data.filter(function (channel) {
                    return recipientChannels.indexOf(channel.id) == -1;
                });
            }, function () {
                toastr.error("Failed to load channels.");
            }).finally(function () {
                $scope.loading = false;
            });
        }, function () {
            toastr.error("Failed to load channels.");
            $scope.loading = false;
        });

        /**
         * Process save.
         */
        $scope.save = function () {
            $scope.saving = true;

            ApiUtils.recipient.channel.store(
                botId,
                recipientId,
                _.map($scope.relation.channels, function (value) {
                    return { id: value.id, type: "manual" };
                })
            ).then(function () {
                $uibModalInstance.close($scope.relation.channels);
            }, function (response) {
                $scope.errors = response.data;
                toastr.error("Failed to add channels.");
            }).finally(function () {
                $scope.saving = false;
            });
        };

        /**
         * Dismiss modal.
         */
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };

        /**
         * If option has changed reset errors.
         */
        $scope.$watchCollection("relation.channels", function () {
            $scope.errors.channels = [];
        });
    });