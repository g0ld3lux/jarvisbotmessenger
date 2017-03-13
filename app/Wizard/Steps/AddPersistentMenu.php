<?php

namespace App\Wizard\Steps;
use App\Models\Respond;

class AddPersistentMenu extends BaseStep
{
    public function __construct($id)
    {
        parent::__construct($id);
    }

    public function getFormData()
    {
        $bot =  request()->user()->bots()->latest()->first();
        $formData['bot'] = $bot;
        $responds = Respond::select('responds.*')
            ->leftJoin('responds_taxonomies', 'responds_taxonomies.respond_id', '=', 'responds.id')
            ->whereNull('responds.label')
            ->where('responds.bot_id', $bot->id)
            ->where('responds_taxonomies.type', 'buttons')
            ->whereNull('responds_taxonomies.parent_id')
            ->where(
                \DB::raw(
                    '(
                        select count(responds_taxonomies.id)
                        from responds_taxonomies
                        where responds_taxonomies.respond_id = responds.id
                        and responds_taxonomies.parent_id is null
                    )'
                ),
                1
            )
            ->get();
        $formData['persistent_menu_responds'] = $responds;

        return $formData;
    }

    public function apply($formData)
    {
        $bot =  request()->user()->bots()->latest()->first();
        $settings = $bot->threadSettings;
        try {
            $settings->persistentMenuRespond()->associate(
                $bot->responds()->findOrFail(request()->input('persistent_menu_respond_id'))
            );
        } catch (\Exception $e) {
            $settings->persistent_menu_respond_id = null;
        }
        return true;
    }

    public function undo()
    {
        return true;
    }
}