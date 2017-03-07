<?php

namespace App\Models;

use App\Models\Communication;
use App\Models\Mass;
use App\Models\Bot\Settings\Thread;
use App\Models\Recipient;
use App\Models\Subscription\Channel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Bot extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bots';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'timezone',
        'page_title',
        'page_id',
        'page_token',
        'page_token_expires_at',
        'app_subscribed',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['page_token_expires_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'app_subscribed' => 'boolean',
    ];

    /**
     * @param string $pageTitle
     * @return void
     */
    public function setPageTitleAttribute($pageTitle)
    {
        $this->attributes['page_title'] = Str::length($pageTitle) > 0 ? $pageTitle : null;
    }

    /**
     * @param string $pageId
     * @return void
     */
    public function setPageIdAttribute($pageId)
    {
        $this->attributes['page_id'] = Str::length($pageId) > 0 ? $pageId : null;
    }

    /**
     * @param string $token
     * @return void
     */
    public function setPageTokenAttribute($token)
    {
        $this->attributes['page_token'] = Str::length($token) > 0 ? $token : null;
    }

    /**
     * Get bot owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Return bot responds.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responds()
    {
        return $this->hasMany(Respond::class, 'bot_id');
    }

    /**
     * Return bot flows.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function flows()
    {
        return $this->hasMany(Flow::class, 'bot_id');
    }

    /**
     * Return bot recipients.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients()
    {
        return $this->hasMany(Recipient::class, 'bot_id');
    }

    /**
     * Return bot recipients variables.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipientsVariables()
    {
        return $this->hasMany(Recipient\Variable::class, 'bot_id');
    }

    /**
     * Return bot related mass messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function massMessages()
    {
        return $this->hasMany(Mass\Message::class, 'bot_id');
    }

    /**
     * Return bot communication log.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function communicationLog()
    {
        return $this->hasMany(Communication\Log::class, 'bot_id');
    }

    /**
     * Return bot statistics.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function statistics()
    {
        return $this->morphMany(Statistic::class, 'statisticable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function threadSettings()
    {
        return $this->hasOne(Thread::class, 'bot_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptionsChannels()
    {
        return $this->hasMany(Channel::class, 'bot_id');
    }
}
