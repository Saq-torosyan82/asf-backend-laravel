<?php

namespace App\Containers\AppSection\Communication\Models;

use App\Ship\Parents\Models\Model;

class Participant extends Model
{
    protected $table = 'communication_participants';

    protected $fillable = [
        'communication_id',
        'user_id'
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
    protected string $resourceKey = 'CommunicationParticipant';

    public function user()
    {
        return $this->belongsTo(\App\Containers\AppSection\User\Models\User::class);
    }

    public function communication()
    {
        return $this->belongsTo(\App\Containers\AppSection\Communication\Models\Communication::class);
    }
}
