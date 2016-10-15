<?php

namespace App\Models\Flow\Matcher;

use App\Models\Flow\Matcher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'matchers_params';

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
     * Return related matcher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function matcher()
    {
        return $this->belongsTo(Matcher::class, 'matcher_id');
    }
}
