<?php

namespace App\Containers\AppSection\UserProfile\Models;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Models\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id', 'key', 'group', 'value'
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
    protected string $resourceKey = 'UserProfile';

    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
