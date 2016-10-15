<?php

namespace App\Models\Respond;

use App\Models\Respond;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    const PARAM_TYPE_SINGLE = 'single';

    const PARAM_TYPE_ARRAY = 'array';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'responds_taxonomies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order',
        'type',
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
     * @var array
     */
    protected $paramsValuesResolved = [];

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
     * @return $this
     */
    public function scopeOfRoot(Builder $query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Return related respond.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function respond()
    {
        return $this->belongsTo(Respond::class, 'respond_id');
    }

    /**
     * Return related params.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function params()
    {
        return $this->hasMany(Respond\Taxonomy\Param::class, 'respond_taxonomy_id');
    }

    /**
     * Return parent element.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Taxonomy::class, 'parent_id');
    }

    /**
     * Return child elements.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Taxonomy::class, 'parent_id');
    }

    /**
     * @return bool
     */
    public function getIsFirstAttribute()
    {
        return array_get($this->attributes, 'is_first', function () {
            return Taxonomy::where('respond_id', $this->respond_id)
                ->where('parent_id', $this->parent_id)
                ->min('order') == $this->order;
        });
    }

    /**
     * @return bool
     */
    public function getIsLastAttribute()
    {
        return array_get($this->attributes, 'is_last', function () {
            return Taxonomy::where('respond_id', $this->respond_id)
                ->where('parent_id', $this->parent_id)
                ->max('order') == $this->order;
        });
    }

    /**
     * @param $key
     * @param string $type
     * @return mixed
     */
    public function getParamValue($key, $type = self::PARAM_TYPE_SINGLE)
    {
        $model = $this;

        $arrayKey = $type.'.'.$key;

        return array_get($this->paramsValuesResolved, $arrayKey, function () use ($model, $key, $type, $arrayKey) {
            if (isset($model->relations['params'])) {
                if ($type == static::PARAM_TYPE_ARRAY) {
                    $value = [];
                } else {
                    $value = null;
                }

                foreach ($model->params as $param) {
                    if ($param->key == $key) {
                        if ($type == static::PARAM_TYPE_ARRAY) {
                            $value[] = $param->value;
                        } else {
                            $value = $param->value;
                        }
                    }
                }

                array_set($model->paramsValuesResolved, $arrayKey, $value);
                return $value;
            } else {
                $param = $model->params()->where('key', $key)->orderBy('order', 'asc');

                if ($type == static::PARAM_TYPE_ARRAY) {
                    $value = $param->lists('value')->all();
                } else {
                    $param = $param->first();

                    if ($param) {
                        $value = $param->value;
                    }
                }

                if (isset($value)) {
                    array_set($model->paramsValuesResolved, $arrayKey, $value);
                    return $value;
                }
            }

            return null;
        });
    }
}
