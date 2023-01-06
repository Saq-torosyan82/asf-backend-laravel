<?php

namespace App\Containers\AppSection\Upload\Models;

use Dyrynda\Database\Support\GeneratesUuid;
use App\Ship\Parents\Models\Model;

class UserDocument extends Model
{
    use GeneratesUuid;

    protected $fillable = [
        'user_id',
        'upload_id',
        'type',
        'is_verified'
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

    public function uuidColumn(): string
    {
        return 'uuid';
    }

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'UserDocument';

    public function Upload()
    {
        return $this->belongsTo(Upload::class);
    }

    public function User()
    {
        return $this->belongsTo(\App\Containers\AppSection\User\Models\User::class);
    }
}
