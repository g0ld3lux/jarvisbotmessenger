<?php

namespace App\Models\Recipient;

use App\Models\Communication;
use App\Models\Project;
use App\Models\Recipient;
use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'recipients_variables';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'accessor',
    ];

    /**
     * Return related project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Related recipients.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recipients()
    {
        return $this->belongsToMany(
            Recipient::class,
            'recipients_variables_recipients',
            'recipient_variable_id',
            'recipient_id'
        );
    }
}
