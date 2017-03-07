<?php

namespace App\Models\Mass;

use App\Models\Flow\Matcher;
use App\Models\Mass\Message\Schedule;
use App\Models\Bot;
use App\Models\Respond;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'mass_messages';

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
     * Return related bot.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bot()
    {
        return $this->belongsTo(Bot::class, 'bot_id');
    }

    /**
     * Return related responds.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function responds()
    {
        return $this
            ->belongsToMany(Respond::class, 'mass_messages_responds', 'mass_message_id', 'respond_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'mass_message_id');
    }

    /**
     * @return bool
     */
    public function getIsStartedAttribute()
    {
        return !is_null($this->started_at);
    }

    /**
     * @return bool
     */
    public function getIsPausedAttribute()
    {
        return !is_null($this->paused_at);
    }

    /**
     * @return bool
     */
    public function getIsFinishedAttribute()
    {
        return !is_null($this->finished_at);
    }
}
