angular
    .module("messengerBotApp")
    .service("ApiUtils", function ($http) {
        return {
            /**
             * Project helpers.
             */
            project: {
                /**
                 * Fetch analytics data.
                 *
                 * @param projectId
                 * @param fields
                 * @param start
                 * @param end
                 * @returns HttpPromise
                 */
                analytics: function (projectId, fields, start, end) {
                    return $http.get(BASE_URL + "/api/project/" + projectId + "/analytics", {
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
                     * @param projectId
                     * @param recipientId
                     * @returns HttpPromise
                     */
                    disable: function (projectId, recipientId) {
                        return $http.post(BASE_URL + "/api/project/" + projectId + "/recipient/" + recipientId + "/chat/disable");
                    },

                    /**
                     * Enable recipient chat.
                     *
                     * @param projectId
                     * @param recipientId
                     * @returns HttpPromise
                     */
                    enable: function (projectId, recipientId) {
                        return $http.post(BASE_URL + "/api/project/" + projectId + "/recipient/" + recipientId + "/chat/enable");
                    }
                },

                /**
                 * Refresh data from API.
                 *
                 * @param projectId
                 * @param recipientId
                 * @returns HttpPromise
                 */
                refresh: function (projectId, recipientId) {
                    return $http.post(BASE_URL + "/api/project/" + projectId + "/recipient/" + recipientId + "/refresh");
                },

                /**
                 * Channel helpers.
                 */
                channel: {
                    /**
                     * Load all recipient channels.
                     *
                     * @param projectId
                     * @param recipientId
                     * @returns HttpPromise
                     */
                    index: function (projectId, recipientId) {
                        return $http.get(BASE_URL + "/api/project/" + projectId + "/recipient/" + recipientId + "/channel", {
                            params: {
                                all: true
                            }
                        });
                    },

                    /**
                     * Remove recipient from channel.
                     *
                     * @param projectId
                     * @param recipientId
                     * @param channelId
                     * @returns HttpPromise
                     */
                    delete: function (projectId, recipientId, channelId) {
                        return $http.delete(BASE_URL + "/api/project/" + projectId + "/recipient/" + recipientId + "/channel/" + channelId);
                    },

                    /**
                     * Attach new channels.
                     *
                     * @param projectId
                     * @param recipientId
                     * @param channels
                     * @returns HttpPromise
                     */
                    store: function (projectId, recipientId, channels) {
                        return $http.post(BASE_URL + "/api/project/" + projectId + "/recipient/" + recipientId + "/channel", { channels: channels });
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
                     * @param projectId
                     * @param channel
                     * @returns HttpPromise
                     */
                    store: function (projectId, channel) {
                        return $http.post(BASE_URL + "/api/project/" + projectId + "/subscription/channel", channel);
                    },

                    /**
                     * Update existing channel.
                     *
                     * @param projectId
                     * @param channelId
                     * @param channel
                     * @returns HttpPromise
                     */
                    update: function (projectId, channelId, channel) {
                        return $http.put(BASE_URL + "/api/project/" + projectId + "/subscription/channel/" + channelId, channel);
                    },

                    /**
                     * Delete channel.
                     *
                     * @param projectId
                     * @param channelId
                     * @returns HttpPromise
                     */
                    delete: function (projectId, channelId) {
                        return $http.delete(BASE_URL + "/api/project/" + projectId + "/subscription/channel/" + channelId);
                    },

                    /**
                     * Recipient helpers.
                     */
                    recipient: {
                        /**
                         * Store new recipients.
                         *
                         * @param projectId
                         * @param channelId
                         * @param recipients
                         * @returns HttpPromise
                         */
                        store: function (projectId, channelId, recipients) {
                            return $http.post(BASE_URL + "/api/project/" + projectId + "/subscription/channel/" + channelId + "/recipient", {
                                recipients: recipients
                            });
                        },

                        /**
                         * Remove recipient from a channel.
                         *
                         * @param projectId
                         * @param channelId
                         * @param recipientId
                         * @returns HttpPromises
                         */
                        delete: function (projectId, channelId, recipientId) {
                            return $http.delete(BASE_URL + "/api/project/" + projectId + "/subscription/channel/" + channelId + "/recipient/" + recipientId);
                        }
                    },

                    /**
                     * Broadcast helpers.
                     */
                    broadcast: {
                        /**
                         * Retrieve single broadcast.
                         *
                         * @param projectId
                         * @param channelId
                         * @param broadcastId
                         * @returns HttpPromise
                         */
                        show: function (projectId, channelId, broadcastId) {
                            return $http.get(BASE_URL + "/api/project/" + projectId + "/subscription/channel/" + channelId + "/broadcast/" + broadcastId);
                        },

                        /**
                         * Store new broadcast.
                         *
                         * @param projectId
                         * @param channelId
                         * @param broadcast
                         * @returns HttpPromise
                         */
                        store: function (projectId, channelId, broadcast) {
                            return $http.post(BASE_URL + "/api/project/" + projectId + "/subscription/channel/" + channelId + "/broadcast", broadcast);
                        },

                        /**
                         * Remove recipient from a channel.
                         *
                         * @param projectId
                         * @param channelId
                         * @param broadcastId
                         * @returns HttpPromises
                         */
                        delete: function (projectId, channelId, broadcastId) {
                            return $http.delete(BASE_URL + "/api/project/" + projectId + "/subscription/channel/" + channelId + "/broadcast/" + broadcastId);
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
                 * @param projectId
                 * @param messageId
                 * @returns HttpPromise
                 */
                show: function (projectId, messageId) {
                    return $http.get(BASE_URL + "/api/project/" + projectId + "/message/" + messageId);
                },

                /**
                 * Remove message.
                 *
                 * @param projectId
                 * @param messageId
                 * @returns HttpPromises
                 */
                delete: function (projectId, messageId) {
                    return $http.delete(BASE_URL + "/api/project/" + projectId + "/message/" + messageId);
                },

                /**
                 * Store new message.
                 *
                 * @param projectId
                 * @param message
                 * @returns HttpPromise
                 */
                store: function (projectId, message) {
                    return $http.post(BASE_URL + "/api/project/" + projectId + "/message", message);
                }
            }
        }
    });