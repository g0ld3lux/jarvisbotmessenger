angular
    .module("messengerBotApp")
    .service("GenericTableService", function ($filter) {
        /**
         * Render created at.
         *
         * @param data
         * @param type
         * @param full
         * @param meta
         * @returns {string}
         */
        this.createdAt = function (data, type, full, meta) {
            return full.created_at ? $filter("projectTime")(full.created_at) : "-";
        };

        /**
         * Render scheduled at.
         *
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
         * Render finished at.
         *
         * @param data
         * @param type
         * @param full
         * @param meta
         * @returns {string}
         */
        this.finishedAt = function (data, type, full, meta) {
            return full.finished_at ? $filter("projectTime")(full.finished_at) : "-";
        };
    });