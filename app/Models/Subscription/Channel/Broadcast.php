<?php

namespace App\Models\Subscription\Channel;

use App\Models\Flow\Matcher;
use App\Models\Recipient;
use App\Models\Respond;
use App\Models\Subscription\Channel;
use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subscriptions_channels_broadcasts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'scheduled_at',
        'started_at',
        'paused_at',
        'finished_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['scheduled_at', 'started_at', 'paused_at', 'finished_at'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'isStarted',
        'isFinished',
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function respond()
    {
        return $this->belongsTo(Respond::class, 'respond_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules()
    {
        return $this->hasMany(Channel\Broadcast\Schedule::class, 'broadcast_id');
    }

    /**
     * Determine if schedule is failed.
     *
     * @return bool
     */
    public function getIsStartedAttribute()
    {
        return !is_null($this->started_at);
    }

    /**
     * Determine if schedule is failed.
     *
     * @return bool
     */
    public function getIsFinishedAttribute()
    {
        return !is_null($this->finished_at);
    }
}
