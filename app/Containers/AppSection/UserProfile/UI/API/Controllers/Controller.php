<?php

namespace App\Containers\AppSection\UserProfile\UI\API\Controllers;

use App\Containers\AppSection\Payment\Actions\SendPaymentConfirmationAction;
use App\Containers\AppSection\Payment\Mails\SendPaymentConfirmationEmail;
use App\Containers\AppSection\System\Enums\Currency;
use App\Containers\AppSection\User\Actions\GetAthletesAction;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use App\Containers\AppSection\UserProfile\Actions\ApproveUserAction;
use App\Containers\AppSection\UserProfile\Actions\GetAllAgentsAction;
use App\Containers\AppSection\UserProfile\Actions\GetAllAthletesAction;
use App\Containers\AppSection\UserProfile\Actions\GetAllLendersAction;
use App\Containers\AppSection\UserProfile\Actions\GetAllOrganisationsAction;
use App\Containers\AppSection\UserProfile\Actions\GetDealsByCountryAction;
use App\Containers\AppSection\UserProfile\Actions\GetNewsCountriesAction;
use App\Containers\AppSection\UserProfile\Actions\GetNewsSportsAction;
use App\Containers\AppSection\UserProfile\Actions\GetUserProfileAction;
use App\Containers\AppSection\UserProfile\Actions\RejectUserAction;
use App\Containers\AppSection\UserProfile\Actions\SaveNewsCountriesAction;
use App\Containers\AppSection\UserProfile\Actions\SaveNewsSportsAction;
use App\Containers\AppSection\UserProfile\Actions\SaveOnboardingLenderAction;
use App\Containers\AppSection\UserProfile\Data\Repositories\UserProfileRepository;
use App\Containers\AppSection\UserProfile\UI\API\Requests\AddUserLenderDealCriteriaRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\AdminGetAllAgentsRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\AdminGetAllAthletesRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\AdminGetAllLendersRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\AdminGetAllBorrowersRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\AdminGetAllOrganisationsRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\AdminGetDealsByCountryRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\ApproveUserRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\RejectUserRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\DeleteUserLenderDealCriteriaRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\GetAgentsRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\GetMyUserProfileRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\GetNewsCountriesRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\GetNewsSportsRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\GetUserAgentAthletesRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\GetUserProfileRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\SaveNewsCountriesRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\SaveNewsSportsRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\SaveOnboardingLenderRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\UpdateMyUserProfile2Request;
use App\Containers\AppSection\UserProfile\UI\API\Requests\UpdateMyUserProfileRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\SaveOnboardingBorrowerRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\GetBasicUserInfoRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\AddAthleteRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\DeleteAthleteRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\GetAgentAthletesRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\AddPreviousTeamsRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\DeleteLenderDealCriteriaRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\AddLenderDealCriteriaRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\UpdateLenderDealCriteriaRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\CheckOrganisationRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\UpdateUserLenderDealCriteriaRequest;
use App\Containers\AppSection\UserProfile\UI\API\Requests\UpdateUserProfileRequest;
use App\Containers\AppSection\UserProfile\UI\API\Transformers\AgentsTransformer;
use App\Containers\AppSection\UserProfile\UI\API\Transformers\UserProfileTransformer;
use App\Containers\AppSection\UserProfile\UI\API\Transformers\BasicUserInfoTransformer;
use App\Containers\AppSection\UserProfile\UI\API\Transformers\AthleteTransformer;
use App\Containers\AppSection\UserProfile\Actions\GetMyUserProfileAction;
use App\Containers\AppSection\UserProfile\Actions\UpdateUserProfileAction;
use App\Containers\AppSection\UserProfile\Actions\SaveOnboardingBorrowerAction;
use App\Containers\AppSection\UserProfile\Actions\GetBasicUserInfoAction;
use App\Containers\AppSection\UserProfile\Actions\GetAllBorrowersAction;
use App\Containers\AppSection\UserProfile\Actions\FormatReadableProfileAction;
use App\Containers\AppSection\UserProfile\Actions\FormatEditableProfileAction;
use App\Containers\AppSection\UserProfile\Actions\AddAthleteAction;
use App\Containers\AppSection\UserProfile\Actions\DeleteAthleteAction;
use App\Containers\AppSection\UserProfile\Actions\AddPreviousTeamsAction;
use App\Containers\AppSection\UserProfile\Actions\DeleteUserProfileAction;
use App\Containers\AppSection\UserProfile\Actions\DeleteLenderDealCriteriaAction;
use App\Containers\AppSection\UserProfile\Actions\CreateLenderDealCriteriaAction;
use App\Containers\AppSection\UserProfile\Actions\UpdateLenderDealCriteriaAction;
use App\Containers\AppSection\UserProfile\Actions\CheckOrganisationAction;
use App\Containers\AppSection\User\Actions\GetChildUsersByParentIdAction;
use App\Ship\Parents\Controllers\ApiController;
use App\Ship\Parents\Exceptions\Exception;
use Illuminate\Http\JsonResponse;
use Log;

class Controller extends ApiController
{
    public function getDashboard(GetMyUserProfileRequest $request): JsonResponse
    {
        $myProfile = app(GetMyUserProfileAction::class)->run($request);
        $formatReadableProfile = app(FormatReadableProfileAction::class)->run($myProfile);
        return new JsonResponse($formatReadableProfile);
    }

    public function EditMyUserProfile(GetMyUserProfileRequest $request): JsonResponse
    {
        $myProfile = app(GetMyUserProfileAction::class)->run($request);
        $formatEditableProfile = app(FormatEditableProfileAction::class)->run($myProfile, $request->user());
        return new JsonResponse($formatEditableProfile);
    }

    public function EditUserProfile(GetUserProfileRequest $request): JsonResponse
    {
        $userProfile = app(GetUserProfileAction::class)->run($request->id);
        // get user by id
        $user = app(FindUserByIdTask::class)->run($request->id);
        $formatEditableProfile = app(FormatEditableProfileAction::class)->run($userProfile, $user);
        return new JsonResponse($formatEditableProfile);
    }

    public function UpdateMyUserProfile2(UpdateMyUserProfile2Request $request): array
    {
        $myProfile = app(UpdateUserProfileAction::class)->run($request);
        return $this->transform($myProfile, UserProfileTransformer::class);
    }

    public function getAgents(GetAgentsRequest $request): array
    {
        return $this->transform($request->user()->agents, AgentsTransformer::class);
    }

    public function UpdateMyUserProfile(UpdateMyUserProfileRequest $request): JsonResponse
    {
        $myProfile = app(UpdateUserProfileAction::class)->run($request, true);
        $formatEditableProfile = app(FormatEditableProfileAction::class)->run($myProfile, $request->user());
        return new JsonResponse($formatEditableProfile);
    }

    public function UpdateUserProfile(UpdateUserProfileRequest $request)
    {
        $userProfile = app(UpdateUserProfileAction::class)->run($request, false);
        return $this->noContent(200);
    }

    public function SaveOnboardingBorrower(SaveOnboardingBorrowerRequest $request): JsonResponse
    {
        $myProfile = app(SaveOnboardingBorrowerAction::class)->run($request);
        if($myProfile instanceof UserProfileRepository) {
            $response = app(FormatEditableProfileAction::class)->run($myProfile, $request->user());
        }else {
            $response = $myProfile;
        }
        return new JsonResponse($response);
    }

    public function approveUser(ApproveUserRequest $request): array {
        $user = app(ApproveUserAction::class)->run($request);
        return $this->transform($user, UserTransformer::class);
    }

    public function rejectUser(RejectUserRequest $request): array {
        $user = app(RejectUserAction::class)->run($request);
        return $this->transform($user, UserTransformer::class);
    }

    public function GetBasicUserInfo(GetBasicUserInfoRequest $request): array
    {
        $basicUserInfo = app(GetBasicUserInfoAction::class)->run();
        return $this->transform($basicUserInfo, BasicUserInfoTransformer::class);
    }

    public function SaveOnboardingLender(SaveOnboardingLenderRequest $request): array
    {
        $basicUserInfo = app(SaveOnboardingLenderAction::class)->run($request);
        return $this->transform($basicUserInfo, BasicUserInfoTransformer::class);
    }

    public function AddAthlete(AddAthleteRequest $request): JsonResponse
    {
        $userInfo = app(AddAthleteAction::class)->run($request);
        return new JsonResponse($userInfo);
    }

    public function DeleteAthlete(DeleteAthleteRequest $request): JsonResponse
    {
        app(DeleteAthleteAction::class)->run($request);
        return $this->noContent(200);
    }

    public function GetAgentAthletes(GetAgentAthletesRequest $request): array
    {
        $athletes = app(GetAthletesAction::class)->run($request);
        return $this->transform($athletes, AthleteTransformer::class);
    }

    public function GetUserAgentAthletes(GetUserAgentAthletesRequest $request): array
    {
        $athletes = app(GetChildUsersByParentIdAction::class)->run($request);
        return $this->transform($athletes, AthleteTransformer::class);
    }

    public function AddPreviousTeams(AddPreviousTeamsRequest $request)
    {
        app(AddPreviousTeamsAction::class)->run($request);
        return $this->noContent(200);
    }

    public function DeleteLenderDealCriteria(DeleteLenderDealCriteriaRequest $request)
    {
        app(DeleteLenderDealCriteriaAction::class)->run($request);
        return $this->noContent(200);
    }

    public function DeleteUserLenderDealCriteria(DeleteUserLenderDealCriteriaRequest $request)
    {
        app(DeleteLenderDealCriteriaAction::class)->run($request);
        return $this->noContent(200);
    }

    public function AddLenderDealCriteria(AddLenderDealCriteriaRequest $request)
    {
        try {
            $criteria = app(CreateLenderDealCriteriaAction::class)->run($request);
        } catch (Exception $e) {
            Log::error('error adding lender deal criteria: ' . $e->getMessage());
            throw $e;
        }

        return new JsonResponse(['id' => $this->encode($criteria->id)]);
    }

    public function AddUserLenderDealCriteria(AddUserLenderDealCriteriaRequest $request)
    {
        try {
            $criteria = app(CreateLenderDealCriteriaAction::class)->run($request);
        } catch (Exception $e) {
            Log::error('error adding lender deal criteria: ' . $e->getMessage());
            throw $e;
        }

        return new JsonResponse(['id' => $this->encode($criteria->id)]);
    }

    public function UpdateLenderDealCriteria(UpdateLenderDealCriteriaRequest $request)
    {
        app(UpdateLenderDealCriteriaAction::class)->run($request);
    }

    public function UpdateUserLenderDealCriteria(UpdateUserLenderDealCriteriaRequest $request)
    {
        app(UpdateLenderDealCriteriaAction::class)->run($request);
    }

    public function getAllLenders(AdminGetAllLendersRequest $request): JsonResponse
    {
        $lenders = app(GetAllLendersAction::class)->run($request, true);
        return new JsonResponse($lenders);
    }

    public function getAllBorrowers(AdminGetAllBorrowersRequest $request): JsonResponse
    {
        $borrowers = app(GetAllBorrowersAction::class)->run($request, true);
        return new JsonResponse($borrowers);
    }

    public function getAllAthletes(AdminGetAllAthletesRequest $request): JsonResponse
    {
        $borrower_type_id = null;
        if ($request->has('btid')) {
            $borrower_type_id = $request->input('btid');
        }
        $athletes = app(GetAllAthletesAction::class)->run(true, $borrower_type_id);
        return new JsonResponse($athletes);
    }

    public function getAllAgents(AdminGetAllAgentsRequest $request): JsonResponse
    {
        $borrower_type_id = null;
        if ($request->has('btid')) {
            $borrower_type_id = $request->input('btid');
        }
        $agents = app(GetAllAgentsAction::class)->run(true, $borrower_type_id);
        return new JsonResponse($agents);
    }

    public function getAllOrganisations(AdminGetAllOrganisationsRequest $request): JsonResponse
    {
        $organisations = app(GetAllOrganisationsAction::class)->run(true);
        return new JsonResponse($organisations);
    }

    public function CheckOrganisation(CheckOrganisationRequest $request)
    {
        $checkOrganisation = app(CheckOrganisationAction::class)->run($request);
        return new JsonResponse(
            [
                'organisation_exists' => $checkOrganisation
            ]
        );
    }

    public function SaveNewsCountries(SaveNewsCountriesRequest $request): JsonResponse {
        $res = app(SaveNewsCountriesAction::class)->run($request);
        return new JsonResponse($res);
    }

    public function SaveNewsSports(SaveNewsSportsRequest $request): JsonResponse {
        $res = app(SaveNewsSportsAction::class)->run($request);
        return new JsonResponse($res);
    }

    public function GetNewsSports(GetNewsSportsRequest $request): Array {
        return app(GetNewsSportsAction::class)->run($request);

    }

    public function GetNewsCountries(GetNewsCountriesRequest $request): Array {
        return app(GetNewsCountriesAction::class)->run($request);
    }
}
