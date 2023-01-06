<?php

namespace App\Containers\AppSection\UserSponsorship\Actions;

use App\Containers\AppSection\System\Enums\BorrowerType;
use App\Containers\AppSection\UserProfile\Tasks\GetBorrowerTypeTask;
use App\Containers\AppSection\UserSponsorship\Exceptions\InvalidBorrowerTypeException;
use App\Containers\AppSection\UserSponsorship\Tasks\GetAllSponsorshipOptionsTask;
use App\Containers\AppSection\UserSponsorship\UI\API\Requests\GetAllSponsorshipOptionsRequest;
use App\Ship\Parents\Actions\Action;

class GetAllSponsorshipOptionsAction extends Action
{
    public function run(GetAllSponsorshipOptionsRequest $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            if (!$request->has('borrower_type')) {
                throw new InvalidBorrowerTypeException('missing borrower_type param');
            }

            // check if value is corporate or athlete
            $borrowerType = $request->input('borrower_type');
            if (($borrowerType != BorrowerType::CORPORATE) && ($borrowerType != BorrowerType::ATHLETE)) {
                throw new InvalidBorrowerTypeException('invalid borrower_type value: ' . $borrowerType);
            }
        } else {
            // get borrower type
            $borrowerType = app(GetBorrowerTypeTask::class)->run($user->id);
            if (is_null($borrowerType)) {
                throw new InvalidBorrowerTypeException();
            }
        }

        return app(GetAllSponsorshipOptionsTask::class)->run($borrowerType);
    }
}
