<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Ship\Parents\Actions\SubAction;

class GetLiveDealSorting extends SubAction
{
    public function run()
    {
        return [
            [
                'label' => 'Date',
                'key' => 'funding_date',
                'options' => [
                    [
                        'label' => 'Ascending',
                        'key' => 'asc',
                    ],
                    [
                        'label' => 'Descending',
                        'key' => 'desc',
                    ]
                ]
            ],
            [
                'label' => 'Interest',
                'key' => 'interest_rate',
                'options' => [
                    [
                        'label' => 'Ascending',
                        'key' => 'asc',
                    ],
                    [
                        'label' => 'Descending',
                        'key' => 'desc',
                    ]
                ]
            ]
        ];
    }
}
