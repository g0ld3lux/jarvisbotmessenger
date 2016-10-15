<?php

namespace App\Models;

use App\Models\Flow\Matcher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Flow extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'flows';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'order',
        'defaulted_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['defaulted_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'is_default',
    ];

    /**
     * Order scope.
     *
     * @param Builder $query
     * @return $this
     */
    public function scopeOrdered(Builder $query)
    {
        return $query->orderBy('order', 'asc');
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
     * Return related matchers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matchers()
    {
        return $this->hasMany(Matcher::class, 'flow_id');
    }

    /**
     * Return related responds.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function responds()
    {
        return $this->belongsToMany(Respond::class, 'flows_responds', 'flow_id', 'respond_id');
    }

    /**
     * @return bool
     */
    public function getIsFirstAttribute()
    {
        return array_get($this->attributes, 'is_first', function () {
            return Flow::where('project_id', $this->project_id)->min('order') == $this->order;
        });
    }

    /**
     * @return bool
     */
    public function getIsLastAttribute()
    {
        return array_get($this->attributes, 'is_last', function () {
            return Flow::where('project_id', $this->project_id)->max('order') == $this->order;
        });
    }

    /**
     * @return bool
     */
    public function getIsDefaultAttribute()
    {
        return array_get($this->attributes, 'is_default', function () {
            return !is_null($this->defaulted_at);
        });
    }
}
