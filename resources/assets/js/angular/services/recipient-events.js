angular
    .module("messengerBotApp")
    .service("RecipientEventsService", function (toastr) {
        /**
         * Listen for chat events.
         *
         * @param scope
         */
        this.chat = function (scope) {
            /**
             * Listen for success.
             */
            scope.$on("recipient.chat.disable.success", function () {
                toastr.success("Disabled chat for recipient.");
            });

            /**
             * Listen for failure.
             */
            scope.$on("recipient.chat.disable.fail", function () {
                toastr.error("Failed to disable chat for recipient.");
            });

            /**
             * Listen for success.
             */
            scope.$on("recipient.chat.enable.success", function () {
                toastr.success("Enabled chat for recipient.");
            });

            /**
             * Listen for failure.
             */
            scope.$on("recipient.chat.enable.fail", function () {
                toastr.error("Failed to enable chat for recipient.");
            });
        };
    });