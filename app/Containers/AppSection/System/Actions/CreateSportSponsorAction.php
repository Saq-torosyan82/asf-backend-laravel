<?php

namespace App\Containers\AppSection\System\Actions;

use App\Containers\AppSection\System\Tasks\CreateSportSponsorTask;
use App\Containers\AppSection\System\Tasks\UploadLogoTask;
use App\Containers\AppSection\Upload\Enums\UploadType;
use App\Ship\Parents\Actions\Action;

class CreateSportSponsorAction extends Action
{
    public function run($request)
    {
        $userId = $request->user_id ?? $request->user()->id;

        return app(CreateSportSponsorTask::class)->run([
            'name' => $request->name,
            'logo' => app(UploadLogoTask::class)->run($request->file('logo'), UploadType::SPORT_SPONSORS ,$userId)
        ]);

    }
}
