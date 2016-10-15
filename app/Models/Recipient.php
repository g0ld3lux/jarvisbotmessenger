<?php

namespace App\Models;

use App\Models\Communication;
use App\Models\Mass\Message\Schedule;
use App\Models\Subscription\Channel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Storage;

class Recipient extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'recipients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference',
        'first_name',
        'last_name',
        'timezone',
        'gender',
        'locale',
        'photo',
        'chat_disabled',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'chat_disabled' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'hasPicture',
        'displayName',
    ];

    /**
     * @param string $firstName
     * @return void
     */
    public function setFirstNameAttribute($firstName)
    {
        $this->attributes['first_name'] = Str::length($firstName) > 0 ? $firstName : null;
    }

    /**
     * @param string $lastName
     * @return void
     */
    public function setLastNameAttribute($lastName)
    {
        $this->attributes['last_name'] = Str::length($lastName) > 0 ? $lastName : null;
    }

    /**
     * @param string $photo
     * @return void
     */
    public function setPhotoAttribute($photo)
    {
        $this->attributes['photo'] = Str::length($photo) > 0 ? $photo : null;
    }

    /**
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        $displayName = [];

        if (Str::length($this->first_name) > 0 || Str::length($this->last_name) > 0) {
            if (Str::length($this->first_name) > 0) {
                $displayName[] = $this->first_name;
            }

            if (Str::length($this->last_name) > 0) {
                $displayName[] = $this->last_name;
            }
        } else {
            $displayName[] = $this->reference;
        }

        return implode(' ', $displayName);
    }

    /**
     * @return bool
     */
    public function getHasPictureAttribute()
    {
        return (bool) Storage::exists('public/recipients/recipient_'. $this->id.'.jpg');
    }

    /**
     * @param $template
     * @return string
     */
    public function getPhotoUrl($template)
    {
        if (Storage::exists('public/recipients/recipient_'. $this->id.'.jpg')) {
            return route('imagecache', [$template, 'recipient_'.$this->id.'.jpg']);
        }

        return null;
    }

    /**
     * Return related project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Return recipient communication log.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function communicationLog()
    {
        return $this->hasMany(Communication\Log::class, 'recipient_id');
    }

    /**
     * Related variables.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function variables()
    {
        return $this->hasMany(Recipient\Variable\Relation::class, 'recipient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'recipient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subscriptionsChannels()
    {
        return $this
            ->belongsToMany(Channel::class, 'subscriptions_channels_recipients', 'recipient_id', 'channel_id')
            ->withTimestamps()
            ->withPivot(['type']);
    }
}
