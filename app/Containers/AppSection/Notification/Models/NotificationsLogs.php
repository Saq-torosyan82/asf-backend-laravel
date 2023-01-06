<?php

namespace App\Containers\AppSection\Notification\Models;

use App\Ship\Parents\Models\Model;

class NotificationsLogs extends Model
{
    protected $table = 'notifications_logs';

    protected $fillable = [
        'type',
        'entity_id',
        'entity_type',
        'subject',
        'to',
        'content',
        'data'
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
    protected string $resourceKey = 'NotificationsLogs';
}
