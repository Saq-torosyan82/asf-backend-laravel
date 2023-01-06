<?php

namespace App\Containers\AppSection\System\Actions;

use App\Containers\AppSection\System\Tasks\CreateSportLeagueTask;
use App\Containers\AppSection\System\Tasks\UploadLogoTask;
use App\Containers\AppSection\Upload\Enums\UploadType;
use App\Ship\Parents\Actions\Action;

class CreateSportLeagueAction extends Action
{
    public function run($request)
    {
        $userId = $request->user_id ?? $request->user()->id;

        return app(CreateSportLeagueTask::class)->run([
            'name' => $request->name,
            'sport_id' => $request->sport_id && $request->sport_id !== '' ? $request->sport_id : 1, // 1 is Football
            'association_name' => $request->association_name,
            'logo' => app(UploadLogoTask::class)->run($request->file('logo'), UploadType::SPORT_LEAGUES ,$userId),
            'association_logo' => app(UploadLogoTask::class)->run($request->file('association_logo'), UploadType::ASSOCIATION_LOGOS ,$userId),
            'confederation_name' => $request->confederation_name,
            'confederation_logo' => app(UploadLogoTask::class)->run($request->file('confederation_logo'), UploadType::CONFEDERATION_LOGOS ,$userId),
        ]);
    }
}
