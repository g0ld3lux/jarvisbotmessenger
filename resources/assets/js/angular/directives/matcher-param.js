angular
    .module("messengerBotApp")
    .directive("matcherParam", function ($parse) {
        return {
            link: function (scope, element, attributes) {
                var matcher = $parse(attributes.matcherParam)(scope),
                    paramName = attributes.param,
                    output;

                angular.forEach(matcher.params, function (param) {
                    if (param.key == paramName) {
                        output = param.value;
                    }
                });

                element.text(output);
            }
        }
    });
