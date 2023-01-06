<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\Deal\Tasks\GetDealsByUserIdTask;
use App\Containers\AppSection\Financial\Enums\FactSectionsName;
use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Tasks\NotificationTask;
use App\Containers\AppSection\System\Enums\BorrowerType;
use App\Containers\AppSection\System\Tasks\FindBorrowerTypeByIdTask;
use App\Containers\AppSection\User\Tasks\GetAutologinUrlTask;
use App\Containers\AppSection\User\Tasks\GetUserByIdTask;
use App\Containers\AppSection\User\Tasks\GetUsersByIdsTask;
use App\Containers\AppSection\UserProfile\Mapper\MapValidator;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileByUserIdTask;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserSponsorship\Actions\SetClubSponsorsAction;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class SaveOnboardingBorrowerAction extends Action
{
    const ACCOUNT_IS_LOCKED = 1;

    public function run(Request $request)
    {
        $userId = $request->user()->id;
        $parentId = null;
        $isLocked = 0;
        $borrowerType = app(FindBorrowerTypeByIdTask::class)->run($request[Group::ACCOUNT][Key::BORROWER_TYPE]);

        $input = $request->except([Group::ACCOUNT]);


        if ($borrowerType && $borrowerType->id === BorrowerType::SPORTS_MARKETING_AGENCY_ID) {
            // Get the admin id , if user parent_id is null this means this user is admin
            $parentId = app(GetUserParentIdSubAction::class)->run($request['company']['registration_number']);
        }

        //app(ValidateOnBoardingDataTask::class)->run($input, $groupedKeysToInsert);

        foreach ($input as $group => $inputKeys) {
            if (!is_array($inputKeys)) {
                continue;
            }

            foreach ($inputKeys as $key => $value) {
                if ($value == "") {
                    continue;
                }
                app(UpdateUserProfileSubAction::class)->run($group, $key, $value, $userId, $borrowerType->type);
            }
        }
        app(UpdateUserProfileSubAction::class)->run(
            Group::ACCOUNT,
            Key::BORROWER_TYPE,
            $borrowerType->type,
            $userId,
            $borrowerType->type
        );
        app(UpdateUserProfileSubAction::class)->run(
            Group::ACCOUNT,
            Key::BORROWER_MODE_ID,
            $borrowerType->id,
            $userId,
            $borrowerType->type
        );



        app(UpdateUserTask::class)->run(
            [
                'first_name' => $request[Group::ACCOUNT][Key::FIRST_NAME],
                'last_name' => $request[Group::ACCOUNT][Key::LAST_NAME],
                'parent_id' => $parentId,
                'is_locked' => $isLocked
            ],
            $userId
        );

        // import data for clubs
        if ($borrowerType && ($borrowerType->type === BorrowerType::CORPORATE) && isset($input['professional']) && isset($input['professional']['club'])) {
            $stadiumFactsIds = FactSectionsName::stadiumFactsIds();
            $club_id = $input['professional']['club'];
            app(ImportUserProfileDataFromFactsDataAction::class)->run($userId, $club_id, $stadiumFactsIds);
            app(SetClubSponsorsAction::class)->run($userId, $club_id);
            app(SetSocialMediaLinksAction::class)->run($userId, $club_id);
        }

        // If parentId is not null means second user of Corporate/Agency tries to onboard,
        // in this case we have to inform about that, and close account till admin will check the information of this user

        if($parentId) {
            $isLocked = self::ACCOUNT_IS_LOCKED;
            $parent = app(GetUserByIdTask::class)->run($parentId);
            if($parent) {
                $adminMailData = [
                    'vars' => [
                        'email' => $request->user()->email,
                        'firstName' => $request[Group::ACCOUNT][Key::FIRST_NAME],
                        'lastName' => $request[Group::ACCOUNT][Key::LAST_NAME],
                        'userType' => $borrowerType->name,
                        'organisationName' => $request[Group::COMPANY][Key::NAME],
                        'registrationNumber' => $request[Group::COMPANY][Key::REGISTRATION_NUMBER],
                        'officeNumber' => $request[Group::CONTACT][Key::OFFICE_PHONE],
                        'phoneNumber' => $request[Group::CONTACT][Key::PHONE],
                        'approve' => config('redirect-urls.approveUserRedirect').'?uid='.$request->user()->getHashedKey(),
                        'reject' =>  config('redirect-urls.rejectUserRedirect').'?uid='.$request->user()->getHashedKey(),
                        'autologin_url' => app(GetAutologinUrlTask::class)->run($parent)
                    ],
                    'allow_multiple' => true,
                ];
                app(NotificationTask::class)->run($parent, MailContext::ADMIN_ONBOARDING_VERIFICATION, $adminMailData);
            }

            $borrowerMailData = [
                'vars' => [
                    'email' => $request->user()->email
                ]
            ];

            app(NotificationTask::class)->run($request->user(), MailContext::BORROWER_ONBOARDING_VERIFICATION, $borrowerMailData);
        }

        if($isLocked === self::ACCOUNT_IS_LOCKED) {
            return [
                'isLocked' => $isLocked
            ];
        }

        return app(FindUserProfileByUserIdTask::class)->run($userId);
    }
}
