<?php

namespace App\Models\Project\Settings;

use App\Models\Flow\Matcher;
use App\Models\Project;
use App\Models\Respond;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Thread extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'thread_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'greeting_text',
    ];

    /**
     * @param $value
     */
    public function setGreetingTextAttribute($value)
    {
        $this->attributes['greeting_text'] = Str::length($value) > 0 ? $value : null;
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getStartedRespond()
    {
        return $this->belongsTo(Respond::class, 'get_started_respond_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function persistentMenuRespond()
    {
        return $this->belongsTo(Respond::class, 'persistent_menu_respond_id');
    }
}
