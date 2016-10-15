<?php

namespace App\Models\Recipient\Variable;

use App\Models\Communication;
use App\Models\Recipient;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'recipients_variables_values';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
        'order',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function relation()
    {
        return $this->belongsTo(Relation::class, 'relation_id');
    }
}
