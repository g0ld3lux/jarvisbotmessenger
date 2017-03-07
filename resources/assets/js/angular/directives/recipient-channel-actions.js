angular
    .module("messengerBotApp")
    .directive("recipientChannelActions", function (ApiUtils, SweetAlert, toastr) {
        return {
            /**
             * Only match attribute name.
             */
            restrict: "E",

            /**
             * Directive scope.
             */
            scope: {
                channel: "="
            },

            /**
             * @param scope
             */
            link: function (scope) {
                /**
                 * Remove recipient from a channel.
                 *
                 * @param channel
                 */
                scope.removeRecipientFromChannel = function (channel) {
                    SweetAlert.swal({
                        title: "Are you sure?",
                        text: "Recipient will be removed from a subscribed channel!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, remove it!",
                        closeOnConfirm: false
                    }, function (confirm){
                        if (confirm) {
                            ApiUtils.recipient.channel.delete(channel.bot_id, channel.recipient_id, channel.channel_id).then(function () {
                                scope.$emit("recipient.channel.delete.success", channel.bot_id, channel.recipient_id, channel.channel_id);
                            }, function () {
                                scope.$emit("recipient.channel.delete.fail", channel.bot_id, channel.recipient_id, channel.channel_id);
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

                buttons.push("<button type=\"button\" class=\"btn btn-danger\" uib-tooltip=\"Remove from channel\" tooltip-trigger=\"mouseenter\" ng-click=\"removeRecipientFromChannel(channel)\"><i class=\"fa fa-trash\"></i></button>");

                buttons.push("<a class=\"btn btn-default\" uib-tooltip=\"Channel details\" tooltip-trigger=\"mouseenter\" ng-href=\"{{ BASE_URL }}/bots/{{ channel.bot_id }}/subscriptions/channels/{{ channel.channel_id }}\"><i class=\"fa fa-arrow-right\"></i></a>");

                return buttons.join(" ");
            }
        }
    });