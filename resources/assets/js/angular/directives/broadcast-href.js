angular
    .module("messengerBotApp")
    .directive("broadcastHref", function () {
        return {
            /**
             * Only match attribute name.
             */
            restrict: "A",

            /**
             * Directive scope.
             */
            scope: {
                broadcast: "=broadcastHref"
            },

            /**
             * Bind href to element.
             */
            link: function (scope, element) {
                element.attr(
                    "href",
                    BASE_URL + "/bots/" + PROJECT_ID + "/subscriptions/channels/" + scope.broadcast.channel_id + "/broadcasts/" + scope.broadcast.id
                );
            }
        }
    });