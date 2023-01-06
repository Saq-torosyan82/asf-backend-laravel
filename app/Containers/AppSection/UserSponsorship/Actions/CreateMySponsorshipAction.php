<?php

namespace App\Containers\AppSection\UserSponsorship\Actions;

use App\Containers\AppSection\System\Enums\BorrowerType;
use App\Containers\AppSection\UserProfile\Tasks\GetBorrowerTypeTask;
use App\Containers\AppSection\UserSponsorship\Exceptions\CreateUserSponsorshipException;
use App\Containers\AppSection\UserSponsorship\Exceptions\UserSponsorshipExistsException;
use App\Containers\AppSection\UserSponsorship\Exceptions\UserUniqueSponsorshipExistsException;
use App\Containers\AppSection\UserSponsorship\Models\UserSponsorship;
use App\Containers\AppSection\UserSponsorship\Tasks\CreateUserSponsorshipTask;
use App\Containers\AppSection\UserSponsorship\Tasks\FindlUserSponsorshipsByTypeTask;
use App\Containers\AppSection\UserSponsorship\UI\API\Requests\CreateMySponsorshipRequest;
use App\Ship\Parents\Actions\Action;
use App\Containers\AppSection\UserSponsorship\Enums\Key;
use Exception;

class CreateMySponsorshipAction extends Action
{
    public function run(CreateMySponsorshipRequest $request): UserSponsorship
    {
        try {
            $user = $request->user();
            $borrowerType = app(GetBorrowerTypeTask::class)->run($user->id);
            if ($borrowerType == BorrowerType::CORPORATE && !in_array($request->type, array_flip(Key::mapClubSponsorKeys()))) {
                throw new Exception('Invalid type for corporate');
            }

            if (Key::isUniqueType($request->type) && $user->sponsorships($request->type)->count()) {
                throw new UserUniqueSponsorshipExistsException('You have already selected a ' . $request->type . ' sponsor');
            }

            // check if sponsorship already exists
            $sponsor = app(FindlUserSponsorshipsByTypeTask::class)->run($user->id, $request->type, $request->id);
            if (!is_null($sponsor)) {
                throw new UserSponsorshipExistsException();
            }

            return app(CreateUserSponsorshipTask::class)->run($user->id, $request->type, $request->id, $request->start_date, $request->end_date);
        }
        catch(UserSponsorshipExistsException $e) {
            throw $e;
        }
        catch(UserUniqueSponsorshipExistsException $e) {
            throw $e;
        }
        catch (Exception $exception) {
            throw new CreateUserSponsorshipException($exception->getMessage());
        }
    }
}
