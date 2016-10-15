<?php

namespace App\Jobs;

use App\Models\Recipient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use Storage;

class DownloadRecipientPhoto extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var Recipient
     */
    protected $recipient;

    /**
     * FetchRecipientDataJob constructor.
     * @param Recipient $recipient
     */
    public function __construct(Recipient $recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * Fetch user image.
     *
     * @return void
     */
    public function handle()
    {
        try {
            if (Str::length($this->recipient->photo) > 0) {
                Storage::put(
                    'public/recipients/recipient_'. $this->recipient->id.'.jpg',
                    file_get_contents($this->recipient->photo)
                );
            }
        } catch (\Exception $e) {
            logger($e);
        }
    }
}
