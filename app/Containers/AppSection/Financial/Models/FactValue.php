<?php

namespace App\Containers\AppSection\Financial\Models;

use App\Containers\AppSection\System\Models\SportClub;
use App\Ship\Parents\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FactValue extends Model
{
    protected $fillable = [
        'fact_name_id',
        'club_id',
        'value',
        'fact_interval_id'
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
    protected string $resourceKey = 'FactValue';


    public function factname(): BelongsTo
    {
        return $this->belongsTo(FactName::class);
    }

    public function sportclub(): BelongsTo
    {
        return $this->belongsTo(SportClub::class/*, 'club_id', 'id'*/);
    }
}