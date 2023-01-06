<?php

namespace App\Containers\AppSection\Upload\Models;

use Dyrynda\Database\Support\GeneratesUuid;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Upload extends Model
{
    use GeneratesUuid;
    use SoftDeletes;

    protected $fillable = [
        'privacy',
        'user_id',
        'uploaded_by',
        'init_file_name',
        'file_mime',
        'file_size',
        'file_name',
        'file_path',
        'extra_data'
    ];

    protected $attributes = [

    ];

    protected $hidden = [

    ];

    protected $casts = [
        'extra_data' => 'array'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Upload';

    public function uuidColumn(): string
    {
        return 'uuid';
    }
}
