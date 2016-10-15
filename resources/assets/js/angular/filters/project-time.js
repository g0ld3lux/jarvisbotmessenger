angular
    .module("messengerBotApp")
    .filter("projectTime", function ($filter) {
        var defaultFormat = "MMM D, YYYY, h:mm A";

        return function (input, project, format) {
            return moment(input).tz(project ? project.timezone : PROJECT_TIMEZONE).format(format ? format : defaultFormat);
        };
    });