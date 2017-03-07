angular
    .module("messengerBotApp")
    .service("ChannelsTableService", function ($filter) {
        /**
         * @param data
         * @param type
         * @param full
         * @param meta
         * @returns {string}
         */
        this.actions = function (data, type, full, meta) {
            return "<a class=\"btn btn-default\" channel-href=\"row\" uib-tooltip=\"Channel details\" tooltip-trigger=\"mouseneter\"><i class=\"fa fa-arrow-right\"></i></a>";
        };

        /**
         * Channels.
         *
         * @type {{}}
         */
        this.recipient = {
            /**
             * @param data
             * @param type
             * @param full
             * @param meta
             * @returns {string}
             */
            joinedAt: function (data, type, full, meta) {
                return full.joined_at ? $filter("botTime")(full.joined_at) : "-";
            },

            /**
             * @param data
             * @param type
             * @param full
             * @param meta
             * @returns {string}
             */
            joinType: function (data, type, full, meta) {
                return full.join_type ? full.join_type : "-";
            },

            /**
             * @param data
             * @param type
             * @param full
             * @param meta
             * @returns {string}
             */
            actions: function (data, type, full, meta) {
                return "<channel-recipient-actions recipient=\"row\"></channel-recipient-actions>";
            }
        };
    });