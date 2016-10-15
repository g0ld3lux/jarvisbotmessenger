<?php

Route::get('/cron/messages/schedules/process', 'CronController@processScheduledMessages');
Route::get('/cron/broadcasts/schedules/process', 'CronController@processBroadcastMessages');
