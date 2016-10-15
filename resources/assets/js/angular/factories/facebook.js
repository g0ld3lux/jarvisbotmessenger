angular
    .module("messengerBotApp.global.facebookService", [])
    .factory("FacebookService", ["$q", function ($q) {
        var scopes = [
            "manage_pages",
            "pages_messaging"
        ];

        return {
            /**
             * Process user login.
             *
             * @returns {*}
             */
            login: function() {
                var deferred = $q.defer();

                FB.getLoginStatus(function(response) {
                    if (response.status === "connected") {
                        deferred.resolve(response);
                    } else {
                        FB.login(function (response) {
                            if (response && response.authResponse) {
                                deferred.resolve(response);
                            } else {
                                deferred.reject("Error occurred");
                            }
                        }, {scope: scopes.join(",")});
                    }
                });

                return deferred.promise;
            },

            /**
             * Fetch user data.
             *
             * @returns {*}
             */
            me: function () {
                var deferred = $q.defer();

                FB.api("/me", function (response) {
                    if (!response || response.error) {
                        deferred.reject("Error occurred");
                    } else {
                        deferred.resolve(response);
                    }
                });

                return deferred.promise;
            },

            /**
             * Fetch user managed pages.
             *
             * @param id
             * @returns {*}
             */
            pages: function (id) {
                var deferred = $q.defer();

                FB.api("/" + id + "/accounts", function (response) {
                    if (!response || response.error) {
                        deferred.reject("Error occurred");
                    } else {
                        deferred.resolve(response);
                    }
                });

                return deferred.promise;
            }
        }
    }]);