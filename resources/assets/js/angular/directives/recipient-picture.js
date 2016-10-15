angular
    .module("messengerBotApp")
    .directive("recipientPicture", function () {
        /**
         * Default template.
         *
         * @type {string}
         */
        var defaultTemplate = "recipient_small";

        return {
            /**
             * Only match attribute name.
             */
            restrict: "A",

            /**
             * Directive scope.
             */
            scope: {
                recipient: "=recipientPicture",
                template: "@pictureTemplate"
            },

            /**
             * Bind picture to element.
             */
            link: function (scope, element) {
                element.attr(
                    "src",
                    BASE_URL + "/images/cache/" + (scope.template || defaultTemplate) + "/recipient_" + scope.recipient.id + ".jpg"
                );
            }
        }
    });