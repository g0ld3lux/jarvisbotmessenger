angular
    .module("messengerBotApp")
    .directive("recipientChatStatus", function (ApiUtils) {
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
                 * Return title for chat button.
                 *
                 * @returns {string}
                 */
                scope.chatButtonTitle = function (recipient) {
                    return scope.recipient.chat_disabled ? "Enable chat" : "Disable chat";
                };

                /**
                 * Toggle recipient chat.
                 *
                 * @param recipient
                 */
                scope.toggleChat = function (recipient) {
                    if (recipient.chat_disabled) {
                        enableChat(recipient);
                    } else {
                        disableChat(recipient);
                    }
                };

                /**
                 * Disable recipient chat.
                 *
                 * @param recipient
                 */
                var disableChat = function (recipient) {
                    ApiUtils.recipient.chat.disable(recipient.bot_id, recipient.id).then(function () {
                        recipient.chat_disabled = true;
                        scope.$emit("recipient.chat.disable.success", recipient);
                    }, function () {
                        scope.$emit("recipient.chat.disable.fail", recipient);
                    });
                };

                /**
                 * Enable recipient chat.
                 *
                 * @param recipient
                 */
                var enableChat = function (recipient) {
                    ApiUtils.recipient.chat.enable(recipient.bot_id, recipient.id).then(function () {
                        recipient.chat_disabled = false;
                        scope.$emit("recipient.chat.enable.success", recipient);
                    }, function () {
                        scope.$emit("recipient.chat.enable.fail", recipient);
                    });
                };
            },

            /**
             * @returns {string}
             */
            template: function () {
                return "<button class=\"btn btn-link\" type=\"button\" uib-tooltip=\"{{ chatButtonTitle(recipient) }}\" ng-click=\"toggleChat(recipient)\" tooltip-trigger=\"mouseenter\"><i class=\"fa\" ng-class=\"{'fa-toggle-off': recipient.chat_disabled, 'fa-toggle-on': !recipient.chat_disabled}\"></i></button>";
            }
        }
    });