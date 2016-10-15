<?php

namespace App\Models\Respond\Taxonomy;

use App\Models\Respond\Taxonomy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'responds_taxonomies_params';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order',
        'key',
        'value',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'order' => 'integer',
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
     * Key scope.
     *
     * @param Builder $query
     * @param string $key
     * @return $this
     */
    public function scopeOfKey(Builder $query, $key)
    {
        return $query->where('key', $key);
    }

    /**
     * Return related taxonomy.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class, 'respond_taxonomy_id');
    }
}
