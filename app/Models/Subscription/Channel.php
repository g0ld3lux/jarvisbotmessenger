<?php

namespace App\Models\Subscription;

use App\Models\Flow\Matcher;
use App\Models\Bot;
use App\Models\Recipient;
use App\Models\Statistic;
use App\Models\Subscription\Channel\Broadcast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subscriptions_channels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Order scope.
     *
     * @param Builder $query
     * @return $this
     */
    public function scopeOrdered(Builder $query)
    {
        return $query->orderBy('name', 'asc');
    }

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recipients()
    {
        return $this
            ->belongsToMany(Recipient::class, 'subscriptions_channels_recipients', 'channel_id', 'recipient_id')
            ->withTimestamps()
            ->withPivot(['type']);
    }

    /**
     * Return statistics.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function statistics()
    {
        return $this->morphMany(Statistic::class, 'statisticable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function broadcasts()
    {
        return $this->hasMany(Broadcast::class, 'channel_id');
    }
}
