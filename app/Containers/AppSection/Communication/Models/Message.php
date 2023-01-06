<?php

namespace App\Containers\AppSection\Communication\Models;

use App\Ship\Parents\Models\Model;

class Message extends Model
{
    protected $table = 'communication_messages';

    protected $fillable = [
        'sender',
        'message_body',
        'communication_id',
        'is_read'
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
    protected string $resourceKey = 'CommunicationMessage';

    public function communication()
    {
        return $this->belongsTo(\App\Containers\AppSection\Communication\Models\Communication::class);
    }
}
