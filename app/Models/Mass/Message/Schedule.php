<?php

namespace App\Models\Mass\Message;

use App\Models\Flow\Matcher;
use App\Models\Mass\Message;
use App\Models\Recipient;
use App\Models\Respond;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mass_messages_schedules';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'error',
        'scheduled_at',
        'sent_at',
        'paused_at',
        'started_at',
        'finished_at',
        'failed_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['scheduled_at', 'sent_at', 'paused_at', 'started_at', 'finished_at', 'failed_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function message()
    {
        return $this->belongsTo(Message::class, 'mass_message_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo(Recipient::class, 'recipient_id');
    }

    /**
     * Determine if schedule is sent.
     *
     * @return bool
     */
    public function getIsSentAttribute()
    {
        return !is_null($this->sent_at);
    }

    /**
     * Determine if schedule is canceled.
     *
     * @return bool
     */
    public function getIsPausedAttribute()
    {
        return !is_null($this->paused_at);
    }

    /**
     * Determine if schedule is started.
     *
     * @return bool
     */
    public function getIsStartedAttribute()
    {
        return !is_null($this->started_at);
    }

    /**
     * Determine if schedule is started.
     *
     * @return bool
     */
    public function getIsFinishedAttribute()
    {
        return !is_null($this->finished_at);
    }

    /**
     * Determine if schedule is failed.
     *
     * @return bool
     */
    public function getIsFailedAttribute()
    {
        return !is_null($this->failed_at);
    }
}
