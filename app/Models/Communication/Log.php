<?php

namespace App\Models\Communication;

use App\Models\Flow;
use App\Models\Bot;
use App\Models\Recipient;
use App\Models\Respond;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'communication_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message',
    ];

    /**
     * Return related bot.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bot()
    {
        return $this->belongsTo(Bot::class, 'bot_id');
    }

    /**
     * Return related flow.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function flow()
    {
        return $this->belongsTo(Flow::class, 'flow_id');
    }

    /**
     * Return related recipient.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient()
    {
        return $this->belongsTo(Recipient::class, 'recipient_id');
    }
}
