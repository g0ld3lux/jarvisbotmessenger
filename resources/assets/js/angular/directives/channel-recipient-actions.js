angular
    .module("messengerBotApp")
    .directive("channelRecipientActions", function (ApiUtils, SweetAlert) {
        return {
            /**
             * Only match attribute name.
             */
            restrict: "E",

            /**
             * Directive scope.
             */
            scope: {
                recipient: "="
            },

            /**
             * @param scope
             */
            link: function (scope) {
                /**
                 * Remove recipient from a channel.
                 *
                 * @param recipient
                 */
                scope.removeRecipientFromChannel = function (recipient) {
                    SweetAlert.swal({
                        title: "Are you sure?",
                        text: "Recipient will be removed from a channel!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, remove it!",
                        closeOnConfirm: false
                    }, function (confirm){
                        if (confirm) {
                            ApiUtils.subscription.channel.recipient.delete(recipient.project_id, recipient.channel_id, recipient.id).then(function () {
                                scope.$emit("channel.recipient.delete.success", recipient.project_id, recipient.channel_id, recipient.id);
                            }, function () {
                                scope.$emit("channel.recipient.delete.fail", recipient.project_id, recipient.channel_id, recipient.id);
                            });
                        }

                        SweetAlert.close();
                    });
                };
            },

            /**
             * @returns {string}
             */
            template: function () {
                var buttons = [];

                buttons.push("<button type=\"button\" class=\"btn btn-danger\" uib-tooltip=\"Remove from channel\" tooltip-trigger=\"mouseenter\" ng-click=\"removeRecipientFromChannel(recipient)\"><i class=\"fa fa-trash\"></i></button>");

                buttons.push("<a class=\"btn btn-default\" uib-tooltip=\"Recipient details\" tooltip-trigger=\"mouseenter\" recipient-href=\"recipient\"><i class=\"fa fa-arrow-right\"></i></a>");

                return buttons.join(" ");
            }
        }
    });