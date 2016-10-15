angular
    .module("messengerBotApp")
    .directive("recipientVariableValue", function ($compile) {
        var renderers = {
            /**
             * Default renderer.
             *
             * @param variable
             * @returns {*}
             * @private
             */
            _: function (variable) {
                if (!variable.values || variable.values.length <= 0) {
                    return "-";
                }

                return _.map(variable.values, function (value) {
                    return value.value;
                }).join(", ");
            },

            /**
             * Gender renderer.
             *
             * @param variable
             * @param scope
             */
            gender: function (variable, scope) {
                if (!variable.values || variable.values.length <= 0) {
                    return "-";
                }

                var gender = variable.values[0].value;

                if (gender == "male") {
                    return $compile("<i uib-tooltip=\"Male\" tooltip-trigger=\"mouseenter\" class=\"fa fa-mars fa-btn\"></i>")(scope);
                }

                if (gender == "female") {
                    return $compile("<i uib-tooltip=\"Female\" tooltip-trigger=\"mouseenter\" class=\"fa fa-venus fa-btn\"></i>")(scope);
                }

                return "-";
            }
        };

        return {
            /**
             * Only match attribute name.
             */
            restrict: "E",

            /**
             * Directive scope.
             */
            scope: {
                variable: "="
            },

            /**
             * Bind picture to element.
             */
            link: function (scope, element) {
                element.html(
                    renderers[scope.variable.variable.accessor]
                        ? renderers[scope.variable.variable.accessor](scope.variable, scope)
                        : renderers["_"](scope.variable, scope)
                );
            }
        }
    });