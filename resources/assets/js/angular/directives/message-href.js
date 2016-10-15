angular
    .module("messengerBotApp")
    .directive("messageHref", function () {
        return {
            /**
             * Only match attribute name.
             */
            restrict: "A",

            /**
             * Directive scope.
             */
            scope: {
                message: "=messageHref"
            },

            /**
             * Bind href to element.
             */
            link: function (scope, element) {
                element.attr(
                    "href",
                    BASE_URL + "/projects/" + scope.message.project_id + "/messages/" + scope.message.id
                );
            }
        }
    });