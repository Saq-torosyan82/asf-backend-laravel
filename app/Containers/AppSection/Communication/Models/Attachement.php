<?php

namespace App\Containers\AppSection\Communication\Models;

use App\Ship\Parents\Models\Model;

class Attachement extends Model
{
    protected $table = 'communication_attachements';

    protected $fillable = [
        'message_id',
        'upload_id',
    ];

    protected $attributes = [

    ];

    protected $hidden = [

    ];

    protected $casts = [

    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'CommunicationAttachement';

    public function communicationMessage()
    {
        return $this->belongsTo(\App\Containers\AppSection\Communication\Models\Message::class);
    }
}
