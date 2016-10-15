<?php

namespace App\Models\Flow;

use App\Models\Flow;
use App\Models\Flow\Matcher\Param;
use Illuminate\Database\Eloquent\Model;

class Matcher extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'matchers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
    ];

    /**
     * @var array
     */
    protected $paramsValuesResolved = [];

    /**
     * Return related flows.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function flow()
    {
        return $this->belongsTo(Flow::class, 'flow_id');
    }

    /**
     * Return matcher params.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function params()
    {
        return $this->hasMany(Param::class, 'matcher_id');
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getParamValue($key)
    {
        $model = $this;

        return array_get($this->paramsValuesResolved, $key, function () use ($model, $key) {
            if (isset($model->relations['params'])) {
                foreach ($model->params as $param) {
                    if ($param->key == $key) {
                        $model->paramsValuesResolved[$key] = $param->value;
                        return $model->paramsValuesResolved[$key];
                    }
                }
            } else {
                $param = $model->params()->where('key', $key)->first();

                if ($param) {
                    $model->paramsValuesResolved[$key] = $param->value;
                    return $model->paramsValuesResolved[$key];
                }
            }

            return null;
        });
    }
}
