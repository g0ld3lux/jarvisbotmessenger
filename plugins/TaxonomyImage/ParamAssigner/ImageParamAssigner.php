<?php

namespace Plugins\TaxonomyImage\ParamAssigner;

use App\Jobs\Responds\Taxonomies\AssignParams\AbstractParamAssigner;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Storage;

class ImageParamAssigner extends AbstractParamAssigner
{
    /**
     * Assign params.
     */
    public function handle()
    {
        $option = $this->param('option');
        $option->value = $this->value('option');
        $option->order = 0;
        $option->save();

        switch ($option->value) {
            case 'url':
                $url = $this->param('url');
                $url->value = $this->value('url');
                $url->order = 1;
                $url->save();
                break;

            case 'upload':
                $source = $this->param('source');
                $source->value = $this->uploadImage();
                $source->order = 1;
                $source->save();
                break;
        }
    }

    /**
     * @return string
     */
    protected function uploadImage()
    {
        $file = $this->request->file('file');

        $folder = 'app/public/taxonomies/';
        $extension = $file->getClientOriginalExtension();
        $filename = $file->getClientOriginalName();
        $filename = substr($filename, 0, Str::length($filename) - (Str::length($extension) + 1));
        $filename = $this->taxonomy->id.'_'.(new Carbon())->format('Y_m_d__H_i_s').'_'.$filename;

        $i = 1;

        $tmp = $filename;

        while (Storage::exists('public/taxonomies/'.$tmp.'.'.$extension)) {
            $tmp = $filename.'_'.$i;
            $i++;
        }

        $file->move(storage_path($folder), $tmp.'.'.$extension);

        return $tmp.'.'.$extension;
    }
}
