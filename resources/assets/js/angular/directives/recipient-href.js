angular
    .module("messengerBotApp")
    .directive("recipientHref", function () {
        return {
            /**
             * Only match attribute name.
             */
            restrict: "A",

            /**
             * Directive scope.
             */
            scope: {
                recipient: "=recipientHref"
            },

            /**
             * Bind href to element.
             */
            link: function (scope, element) {
                element.attr(
                    "href",
                    BASE_URL + "/bots/" + scope.recipient.bot_id + "/recipients/" + scope.recipient.id
                );
            }
        }
    });