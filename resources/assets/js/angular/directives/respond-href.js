angular
    .module("messengerBotApp")
    .directive("respondHref", function () {
        return {
            /**
             * Only match attribute name.
             */
            restrict: "A",

            /**
             * Directive scope.
             */
            scope: {
                respond: "=respondHref"
            },

            /**
             * Bind href to element.
             */
            link: function (scope, element) {
                element.attr(
                    "href",
                    BASE_URL + "/bots/" + scope.respond.bot_id + "/responds/" + scope.respond.id + "/edit"
                );
            }
        }
    });