<?php

namespace App\Models;

use App\Models\Respond\Taxonomy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Respond extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'responds';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'label',
    ];

    /**
     * Filter global responds.
     *
     * @param $query
     * @return mixed
     */
    public function scopeGlobal($query)
    {
        return $query->whereNull('label');
    }

    /**
     * Set label attribute.
     *
     * @param $label
     */
    public function setLabelAttribute($label)
    {
        $this->attributes['label'] = Str::length($label) > 0 ? $label : null;
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
     * Return respond taxonomies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taxonomies()
    {
        return $this->hasMany(Taxonomy::class, 'respond_id');
    }

    /**
     * Return related responds.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function flows()
    {
        return $this->belongsToMany(Flow::class, 'flows_responds', 'respond_id', 'flow_id');
    }
}
