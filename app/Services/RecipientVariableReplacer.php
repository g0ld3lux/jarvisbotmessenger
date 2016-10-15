<?php

namespace App\Services;

use App\Models\Recipient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class RecipientVariableReplacer
{
    /**
     * @param Recipient $recipient
     * @param $text
     * @return mixed
     */
    public function replace(Recipient $recipient, $text)
    {
        $service = $this;

        $this->getVariables($recipient)->each(function (Recipient\Variable\Relation $relation) use ($service, &$text) {
            if (!$relation->variable) {
                return;
            }

            $method = 'replace'.ucfirst($relation->variable->type);

            if (method_exists($service, $method)) {
                $text = $service->{$method}($relation, $text);
            }
        });

        return $text;
    }

    /**
     * @param Recipient $recipient
     * @return Collection
     */
    protected function getVariables(Recipient $recipient)
    {
        return Recipient\Variable\Relation::with('variable', 'values')
            ->where('recipient_id', $recipient->id)
            ->get()
            ->keyBy(function (Recipient\Variable\Relation $relation) {
                return $relation->variable->accessor;
            });
    }

    /**
     * @param Recipient\Variable\Relation $relation
     * @param $text
     * @return mixed
     */
    protected function replaceText(Recipient\Variable\Relation $relation, $text)
    {
        $value = $relation->getParamValue('text');

        return str_replace('{$'.$relation->variable->accessor.'}', $value, $text);
    }
}
