<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\Authorization\Tasks\FindRoleTask;
use App\Containers\AppSection\System\Enums\BorrowerType;
use App\Containers\AppSection\Upload\Actions\UploadAvatarAction;
use App\Containers\AppSection\User\Actions\SetLoginTokenSubAction;
use App\Containers\AppSection\User\Mails\LenderRegisteredMail;
use App\Containers\AppSection\User\Tasks\CreateUserByCredentialsTask;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Mapper\MapValidator;
use App\Containers\AppSection\UserProfile\Mapper\Profile;
use App\Containers\AppSection\UserProfile\Models\UserProfile;
use App\Containers\AppSection\UserProfile\Tasks\CreateLenderDealCriteriaTask;
use App\Containers\AppSection\UserProfile\Tasks\CreateLenderDealCriterionCountryTask;
use App\Containers\AppSection\UserProfile\Tasks\CreateLenderDealCriterionCurrencyTask;
use App\Containers\AppSection\UserProfile\Tasks\CreateLenderDealCriterionSportTask;
use App\Containers\AppSection\UserProfile\Tasks\CreateUserProfileTask;
use App\Containers\AppSection\UserProfile\UI\API\Requests\SaveOnboardingLenderRequest;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Mail;
use Exception;

class SaveOnboardingLenderAction extends Action
{
    public function run(SaveOnboardingLenderRequest $request): ?UserProfile
    {
        try {
            $input = $request->all();

            $user = app(CreateUserByCredentialsTask::class)->run(
                false,
                $input['lender']['email'],
                '',
                $input['contact']['firstName'],
                $input['contact']['lastName']
            );
            $user->assignRole(app(FindRoleTask::class)->run(PermissionType::LENDER));

            $lenderMap = Profile::API_LENDER_MAP;
            foreach ($input as $key => $value) {
                if ($key != Profile::SECTION_LENDER && $key != Profile::SECTION_CONTACT) {
                    continue;
                }

                foreach ($value as $key2 => $value2) {
                    $keyGroup = $lenderMap[$key][$key2] ?? null;
                    if (!isset($keyGroup)) {
                        continue;
                    }

                    // validate the field

                    app(CreateUserProfileTask::class)->run(
                        $user->id,
                        $keyGroup['key'],
                        $keyGroup['group'],
                        $value2,
                        PermissionType::LENDER
                    );
                }
            }

            // add avatar
            if ($request->has('avatar') && $request->file('avatar')) {
                $uploadId = app(UploadAvatarAction::class)->run($request, $user->id, PermissionType::LENDER);
            }

            foreach ($input['criteria'] as $criterion) {
                $lenderDealCriteria = app(CreateLenderDealCriteriaTask::class)->run(
                    $user->id,
                    $criterion['dealType']['id'],
                    $criterion['minAmount']['id'],
                    $criterion['maxAmount']['id'],
                    $criterion['minTenor']['id'],
                    $criterion['maxTenor']['id'],
                    $criterion['minInterestRate']['id'],
                    $criterion['interestRange']['id'],
                    $criterion['additionalInfo']
                );

                foreach ($criterion['currency'] as $currency) {
                    app(CreateLenderDealCriterionCurrencyTask::class)->run(
                        $lenderDealCriteria->id,
                        $currency['id']
                    );
                }

                foreach ($criterion['country'] as $country) {
                    app(CreateLenderDealCriterionCountryTask::class)->run(
                        $lenderDealCriteria->id,
                        $country['id']
                    );
                }

                foreach ($criterion['sport'] as $sport) {
                    app(CreateLenderDealCriterionSportTask::class)->run(
                        $lenderDealCriteria->id,
                        $sport['id']
                    );
                }
            }

            $loginTokenExpiration = config('appSection-authentication.login_lender_token_expiration');
            app(SetLoginTokenSubAction::class)->run($user->id, $loginTokenExpiration);
            Mail::send(new LenderRegisteredMail($user));
        } catch (Exception $e) {
            die($e->getMessage());
            throw new InternalErrorException();
        }

        return null;
    }
}
