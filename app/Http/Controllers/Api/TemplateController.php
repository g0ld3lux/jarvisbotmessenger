<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use App\Models\Bot;
use App\Services\Flow\Exchange;
use App\Http\Requests\Api\Template\CloneTemplateRequest;

class TemplateController extends Controller
{

    
    public function index()
    {
      return Template::approved()->get(['id', 'name'])->toArray();
    //   return Template::get(['id', 'name'])->toArray();
    }
    /**
     * @param ImportRequest $request
     * @param Bot $bot
     * @param Exchange $exchange
     * @return \Illuminate\Http\JsonResponse
     */

    public function loadTemplateToFlows(CloneTemplateRequest $request, Bot $bot, Exchange $exchange)
    {
        
        $this->authorize('view', $bot);
        $templates = Template::approved()->findMany($request->input('templates'));
        // $templates = Template::findMany($request->input('templates'));
        
        $templates = $templates->pluck('flows','id');
        
         foreach($templates as $data){
            try {
            $data = json_decode($data);
                if ($exchange->import($bot, $data, $data->meta->version)) {
                    return response()->json(['success' => true]);
                }
            } catch (\Exception $e) {
                logger($e);
            }
        }
        return response()->json(['success' => false], 422);
        
    }
}
