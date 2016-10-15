angular
    .module("messengerBotApp")
    .directive("projectTime", function () {
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
                project: "=projectTime",
                format: "@format",
                time: "=time"
            },

            /**
             * Bind href to element.
             */
            link: function (scope, element) {
                element.text(
                    moment(scope.time)
                        .tz(scope.project ? scope.project.timezone : PROJECT_TIMEZONE)
                        .format(scope.format ? scope.format : defaultFormat)
                );
            }
        }
    });