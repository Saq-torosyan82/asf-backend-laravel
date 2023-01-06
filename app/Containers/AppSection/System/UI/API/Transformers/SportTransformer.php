<?php

namespace App\Containers\AppSection\System\UI\API\Transformers;

use App\Containers\AppSection\System\Models\Sport;
use App\Ship\Parents\Transformers\Transformer;

class SportTransformer extends Transformer
{
    /**
     * @var  array
     */
    protected $defaultIncludes = [

    ];

    /**
     * @var  array
     */
    protected $availableIncludes = [

    ];

    public function transform(Sport $sport): array
    {
        $has_country = false;
        $has_league = false;
        $has_club = false;
        $with_league = [
            1 => 1,
            2 => 1,
            3 => 1,
            8 => 1,
            9 => 1,
            10 => 1,
            11 => 1,
            15 => 1,
        ];

        if (isset($with_league[$sport->id])) {
            $has_country = true;
            $has_league = true;
            $has_club = true;
        }

        if ($sport->id == 5) {
            $has_country = true;
            $has_club = true;
        }

        if($sport->id == 18)
        {
            $has_club = true;
        }

        return [
            'id' => $sport->getHashedKey(),
            'name' => $sport->name,
            'has_country' => $has_country,
            'has_league' => $has_league,
            'has_club' => $has_club
        ];
    }
}
