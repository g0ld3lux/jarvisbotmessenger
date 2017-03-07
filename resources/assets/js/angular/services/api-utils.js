angular
    .module("messengerBotApp")
    .service("ApiUtils", function ($http) {
        return {
            /**
             * Bot helpers.
             */
            bot: {
                /**
                 * Fetch analytics data.
                 *
                 * @param botId
                 * @param fields
                 * @param start
                 * @param end
                 * @returns HttpPromise
                 */
                analytics: function (botId, fields, start, end) {
                    return $http.get(BASE_URL + "/api/bot/" + botId + "/analytics", {
                        params: {
                            "fields[]": fields,
                            start: start,
                            end: end
                        }
                    });
                }
            },

            /**
             * Recipient helpers.
             */
            recipient: {
                /**
                 * Chat helpers.
                 */
                chat: {
                    /**
                     * Disable recipient chat.
                     *
                     * @param botId
                     * @param recipientId
                     * @returns HttpPromise
                     */
                    disable: function (botId, recipientId) {
                        return $http.post(BASE_URL + "/api/bot/" + botId + "/recipient/" + recipientId + "/chat/disable");
                    },

                    /**
                     * Enable recipient chat.
                     *
                     * @param botId
                     * @param recipientId
                     * @returns HttpPromise
                     */
                    enable: function (botId, recipientId) {
                        return $http.post(BASE_URL + "/api/bot/" + botId + "/recipient/" + recipientId + "/chat/enable");
                    }
                },

                /**
                 * Refresh data from API.
                 *
                 * @param botId
                 * @param recipientId
                 * @returns HttpPromise
                 */
                refresh: function (botId, recipientId) {
                    return $http.post(BASE_URL + "/api/bot/" + botId + "/recipient/" + recipientId + "/refresh");
                },

                /**
                 * Channel helpers.
                 */
                channel: {
                    /**
                     * Load all recipient channels.
                     *
                     * @param botId
                     * @param recipientId
                     * @returns HttpPromise
                     */
                    index: function (botId, recipientId) {
                        return $http.get(BASE_URL + "/api/bot/" + botId + "/recipient/" + recipientId + "/channel", {
                            params: {
                                all: true
                            }
                        });
                    },

                    /**
                     * Remove recipient from channel.
                     *
                     * @param botId
                     * @param recipientId
                     * @param channelId
                     * @returns HttpPromise
                     */
                    delete: function (botId, recipientId, channelId) {
                        return $http.delete(BASE_URL + "/api/bot/" + botId + "/recipient/" + recipientId + "/channel/" + channelId);
                    },

                    /**
                     * Attach new channels.
                     *
                     * @param botId
                     * @param recipientId
                     * @param channels
                     * @returns HttpPromise
                     */
                    store: function (botId, recipientId, channels) {
                        return $http.post(BASE_URL + "/api/bot/" + botId + "/recipient/" + recipientId + "/channel", { channels: channels });
                    }
                }
            },

            /**
             * Subscription helpers.
             */
            subscription: {
                /**
                 * Channel helpers.
                 */
                channel: {
                    /**
                     * Store new channel.
                     *
                     * @param botId
                     * @param channel
                     * @returns HttpPromise
                     */
                    store: function (botId, channel) {
                        return $http.post(BASE_URL + "/api/bot/" + botId + "/subscription/channel", channel);
                    },

                    /**
                     * Update existing channel.
                     *
                     * @param botId
                     * @param channelId
                     * @param channel
                     * @returns HttpPromise
                     */
                    update: function (botId, channelId, channel) {
                        return $http.put(BASE_URL + "/api/bot/" + botId + "/subscription/channel/" + channelId, channel);
                    },

                    /**
                     * Delete channel.
                     *
                     * @param botId
                     * @param channelId
                     * @returns HttpPromise
                     */
                    delete: function (botId, channelId) {
                        return $http.delete(BASE_URL + "/api/bot/" + botId + "/subscription/channel/" + channelId);
                    },

                    /**
                     * Recipient helpers.
                     */
                    recipient: {
                        /**
                         * Store new recipients.
                         *
                         * @param botId
                         * @param channelId
                         * @param recipients
                         * @returns HttpPromise
                         */
                        store: function (botId, channelId, recipients) {
                            return $http.post(BASE_URL + "/api/bot/" + botId + "/subscription/channel/" + channelId + "/recipient", {
                                recipients: recipients
                            });
                        },

                        /**
                         * Remove recipient from a channel.
                         *
                         * @param botId
                         * @param channelId
                         * @param recipientId
                         * @returns HttpPromises
                         */
                        delete: function (botId, channelId, recipientId) {
                            return $http.delete(BASE_URL + "/api/bot/" + botId + "/subscription/channel/" + channelId + "/recipient/" + recipientId);
                        }
                    },

                    /**
                     * Broadcast helpers.
                     */
                    broadcast: {
                        /**
                         * Retrieve single broadcast.
                         *
                         * @param botId
                         * @param channelId
                         * @param broadcastId
                         * @returns HttpPromise
                         */
                        show: function (botId, channelId, broadcastId) {
                            return $http.get(BASE_URL + "/api/bot/" + botId + "/subscription/channel/" + channelId + "/broadcast/" + broadcastId);
                        },

                        /**
                         * Store new broadcast.
                         *
                         * @param botId
                         * @param channelId
                         * @param broadcast
                         * @returns HttpPromise
                         */
                        store: function (botId, channelId, broadcast) {
                            return $http.post(BASE_URL + "/api/bot/" + botId + "/subscription/channel/" + channelId + "/broadcast", broadcast);
                        },

                        /**
                         * Remove recipient from a channel.
                         *
                         * @param botId
                         * @param channelId
                         * @param broadcastId
                         * @returns HttpPromises
                         */
                        delete: function (botId, channelId, broadcastId) {
                            return $http.delete(BASE_URL + "/api/bot/" + botId + "/subscription/channel/" + channelId + "/broadcast/" + broadcastId);
                        }
                    }
                }
            },

            /**
             * Message helpers.
             */
            message: {
                /**
                 * Retrieve single message.
                 *
                 * @param botId
                 * @param messageId
                 * @returns HttpPromise
                 */
                show: function (botId, messageId) {
                    return $http.get(BASE_URL + "/api/bot/" + botId + "/message/" + messageId);
                },

                /**
                 * Remove message.
                 *
                 * @param botId
                 * @param messageId
                 * @returns HttpPromises
                 */
                delete: function (botId, messageId) {
                    return $http.delete(BASE_URL + "/api/bot/" + botId + "/message/" + messageId);
                },

                /**
                 * Store new message.
                 *
                 * @param botId
                 * @param message
                 * @returns HttpPromise
                 */
                store: function (botId, message) {
                    return $http.post(BASE_URL + "/api/bot/" + botId + "/message", message);
                }
            }
        }
    });