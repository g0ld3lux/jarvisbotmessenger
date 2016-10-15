angular
    .module("messengerBotApp")
    .config(function (toastrConfig) {
        /**
         * Set toastr settings.
         */
        angular.extend(toastrConfig, {
            positionClass: 'toast-bottom-right'
        });
    });