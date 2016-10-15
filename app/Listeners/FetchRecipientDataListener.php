<?php

namespace App\Listeners;

use App\Jobs\DownloadRecipientPhoto;
use App\Jobs\Recipients\FetchRecipientDataJob;
use App\Models\Recipient;
use Illuminate\Contracts\Bus\Dispatcher;

class FetchRecipientDataListener
{
    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * FetchRecipientDataListener constructor.
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param Recipient $recipient
     */
    public function handle(Recipient $recipient)
    {
        $data = $this->dispatcher->dispatchNow(new FetchRecipientDataJob(
            $recipient->reference,
            $recipient->project->page_token
        ));

        $recipient->fill([
            'first_name' => array_get($data, 'first_name'),
            'last_name' => array_get($data, 'last_name'),
            'locale' => array_get($data, 'locale'),
            'gender' => array_get($data, 'gender'),
            'timezone' => timezone_gmt_name_from_offset(array_get($data, 'timezone')),
            'photo' => array_get($data, 'profile_pic'),
        ]);

        $recipient->save();

        $this->dispatcher->dispatch(new DownloadRecipientPhoto($recipient));
    }
}
