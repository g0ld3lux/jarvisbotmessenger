angular
    .module("messengerBotApp")
    .filter("botTime", function ($filter) {
        var defaultFormat = "MMM D, YYYY, h:mm A";

        return function (input, bot, format) {
            return moment(input).tz(bot ? bot.timezone : PROJECT_TIMEZONE).format(format ? format : defaultFormat);
        };
    });