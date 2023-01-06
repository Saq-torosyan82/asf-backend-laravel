<?php

namespace App\Containers\AppSection\System\Actions;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\System\Tasks\GetAllSportCountriesTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllSportCountriesAction extends Action
{
    use HashIdTrait;

    public function run(Request $request)
    {
        $sport_list = app(GetAllSportCountriesTask::class)->run($request->sport_id);
        $data = [];
        // this should be improved
        foreach ($sport_list as $row) {
            if (isset($data[$row->country->id])) {
                continue;
            }

            $data[$row->country->id] = [
                'id' => $this->encode($row->country->id),
                'name' => $row->country->name,
            ];
        }

        return array_values($data);
    }
}
