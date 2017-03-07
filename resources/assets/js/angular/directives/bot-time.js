angular
    .module("messengerBotApp")
    .directive("botTime", function () {
        var defaultFormat = "MMM D, YYYY, h:mm A";

        return {
            /**
             * Only match attribute name.
             */
            restrict: "A",

            /**
             * Directive scope.
             */
            scope: {
                bot: "=botTime",
                format: "@format",
                time: "=time"
            },

            /**
             * Bind href to element.
             */
            link: function (scope, element) {
                element.text(
                    moment(scope.time)
                        .tz(scope.bot ? scope.bot.timezone : PROJECT_TIMEZONE)
                        .format(scope.format ? scope.format : defaultFormat)
                );
            }
        }
    });