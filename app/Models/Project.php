<?php

namespace App\Models;

use App\Models\Communication;
use App\Models\Mass;
use App\Models\Project\Settings\Thread;
use App\Models\Recipient;
use App\Models\Subscription\Channel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

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
     * Get project owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Return project responds.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responds()
    {
        return $this->hasMany(Respond::class, 'project_id');
    }

    /**
     * Return project flows.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function flows()
    {
        return $this->hasMany(Flow::class, 'project_id');
    }

    /**
     * Return project recipients.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients()
    {
        return $this->hasMany(Recipient::class, 'project_id');
    }

    /**
     * Return project recipients variables.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipientsVariables()
    {
        return $this->hasMany(Recipient\Variable::class, 'project_id');
    }

    /**
     * Return project related mass messages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function massMessages()
    {
        return $this->hasMany(Mass\Message::class, 'project_id');
    }

    /**
     * Return project communication log.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function communicationLog()
    {
        return $this->hasMany(Communication\Log::class, 'project_id');
    }

    /**
     * Return project statistics.
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
        return $this->hasOne(Thread::class, 'project_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptionsChannels()
    {
        return $this->hasMany(Channel::class, 'project_id');
    }
}
