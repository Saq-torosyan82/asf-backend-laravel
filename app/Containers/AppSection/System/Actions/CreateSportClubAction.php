<?php

namespace App\Containers\AppSection\System\Actions;

use App\Containers\AppSection\System\Tasks\CreateSportClubTask;
use App\Containers\AppSection\System\Tasks\UploadLogoTask;
use App\Containers\AppSection\Upload\Enums\UploadType;
use App\Ship\Parents\Actions\Action;

class CreateSportClubAction extends Action
{
    public function run($request)
    {
        $userId = $request->user_id ?? $request->user()->id;

        return app(CreateSportClubTask::class)->run([
            'name' => $request->name,
            'league_id' => $request->league_id,
            'country_id' => $request->country_id,
            'sport_id' => $request->sport_id && $request->sport_id !== '' ? $request->sport_id : 1, // 1 is Football
            'logo' => app(UploadLogoTask::class)->run($request->file('logo'), UploadType::SPORT_CLUBS ,$userId)
        ]);
    }
}
