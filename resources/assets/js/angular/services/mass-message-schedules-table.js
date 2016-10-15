angular
    .module("messengerBotApp")
    .service("MassMessageSchedulesTableService", function ($filter) {
        this.recipient = {
            /**
             * @param data
             * @param type
             * @param full
             * @param meta
             * @returns {string}
             */
            picture: function (data, type, full, meta) {
                return full.recipient.hasPicture ? "<img class=\"img-circle\" recipient-picture=\"row.recipient\">" : "";
            },

            /**
             * @param data
             * @param type
             * @param full
             * @param meta
             * @returns {*}
             */
            displayName: function (data, type, full, meta) {
                return full.recipient.displayName ? full.recipient.displayName : "-";
            },

            /**
             * @param data
             * @param type
             * @param full
             * @param meta
             * @returns {*}
             */
            timezone: function (data, type, full, meta) {
                return full.recipient.timezone ? full.recipient.timezone : "-";
            }
        };

        /**
         * @param data
         * @param type
         * @param full
         * @param meta
         * @returns {string}
         */
        this.scheduledAt = function (data, type, full, meta) {
            return full.scheduled_at ? $filter("projectTime")(full.scheduled_at) : "-";
        };

        /**
         * @param data
         * @param type
         * @param full
         * @param meta
         * @returns {string}
         */
        this.sentAt = function (data, type, full, meta) {
            return full.sent_at ? $filter("projectTime")(full.sent_at) : "not sent yet";
        }
    });