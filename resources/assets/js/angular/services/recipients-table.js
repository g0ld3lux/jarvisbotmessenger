angular
    .module("messengerBotApp")
    .service("RecipientsTableService", function ($filter) {
        /**
         * @param data
         * @param type
         * @param full
         * @param meta
         * @returns {string}
         */
        this.picture = function (data, type, full, meta) {
            return full.hasPicture ? "<img class=\"img-circle\" recipient-picture=\"row\">" : "";
        };

        /**
         * @param data
         * @param type
         * @param full
         * @param meta
         * @returns {string}
         */
        this.gender = function (data, type, full, meta) {
            if (full.gender == "male") {
                return "<i uib-tooltip=\"Male\" tooltip-trigger=\"mouseenter\" class=\"fa fa-mars\"></i>";
            }

            if (full.gender == "female") {
                return "<i uib-tooltip=\"Female\" tooltip-trigger=\"mouseenter\" class=\"fa fa-venus\"></i>";
            }

            return "-";
        };

        /**
         * @param data
         * @param type
         * @param full
         * @param meta
         * @returns {string}
         */
        this.firstName = function (data, type, full, meta) {
            return full.first_name ? full.first_name : "-";
        };

        /**
         * @param data
         * @param type
         * @param full
         * @param meta
         * @returns {string}
         */
        this.lastName = function (data, type, full, meta) {
            return full.last_name ? full.last_name : "-";
        };

        /**
         * @param data
         * @param type
         * @param full
         * @param meta
         * @returns {string}
         */
        this.chatStatus = function (data, type, full, meta) {
            return "<recipient-chat-status recipient=\"row\"></recipient-chat-status>"
        };

        /**
         * @param data
         * @param type
         * @param full
         * @param meta
         * @returns {string}
         */
        this.actions = function (data, type, full, meta) {
            return "<a class=\"btn btn-default\" recipient-href=\"row\" uib-tooltip=\"Recipient details\" tooltip-trigger=\"mouseneter\"><i class=\"fa fa-arrow-right\"></i></a>";
        };

        /**
         * Channels.
         *
         * @type {{}}
         */
        this.channel = {
            /**
             * @param data
             * @param type
             * @param full
             * @param meta
             * @returns {string}
             */
            actions: function (data, type, full, meta) {
                return "<recipient-channel-actions channel=\"row\"></recipient-channel-actions>";
            }
        };

        /**
         * History.
         *
         * @type {{}}
         */
        this.history = {
            /**
             * Respond.
             *
             * @param data
             * @param type
             * @param full
             * @param meta
             * @returns {string}
             */
            respond: function (data, type, full, meta) {
                return full.flow ? full.flow.title : "-";
            }
        };
    });