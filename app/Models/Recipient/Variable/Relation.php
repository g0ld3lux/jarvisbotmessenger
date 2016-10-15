<?php

namespace App\Models\Recipient\Variable;

use App\Models\Communication;
use App\Models\Recipient;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    const PARAM_TYPE_SINGLE = 'single';

    const PARAM_TYPE_ARRAY = 'array';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'recipients_variables_recipients';

    /**
     * @var array
     */
    protected $paramsValuesResolved = [];

    /**
     * @param Builder $query
     * @param $id
     * @return mixed
     */
    public function scopeOfVariable(Builder $query, $id)
    {
        return $query->where('recipient_variable_id', $id);
    }

    /**
     * Return related variable.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function variable()
    {
        return $this->belongsTo(Recipient\Variable::class, 'recipient_variable_id');
    }

    /**
     * Return related recipient.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recipient()
    {
        return $this->belongsTo(Recipient::class, 'recipient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values()
    {
        return $this->hasMany(Recipient\Variable\Value::class, 'relation_id');
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
            if (isset($model->relations['values'])) {
                if ($type == static::PARAM_TYPE_ARRAY) {
                    $value = [];
                } else {
                    $value = null;
                }

                foreach ($model->values as $param) {
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
                $param = $model->values()->where('key', $key)->orderBy('order', 'asc');

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
