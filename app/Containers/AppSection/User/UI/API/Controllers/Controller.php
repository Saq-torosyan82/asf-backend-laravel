<?php

namespace App\Containers\AppSection\User\UI\API\Controllers;

use App\Containers\AppSection\User\Actions\ {
    CheckAthleteAction,
    CheckEmailAvailabilityAction,
    CreateAdminAction,
    DeleteAgentAction,
    DeleteUserAction,
    DisableUserAccountAction,
    FindUserByIdAction,
    ForgotPasswordAction,
    GetAllAdminsAction,
    GetAllClientsAction,
    GetAllUsersAction,
    GetAuthenticatedUserAction,
    RegisterUserAction,
    ResetPasswordAction,
    UpdateUserAction,
    DisableAccountAction,
    MagicLinkAction,
    CheckPasswordSetAction,
    ChangePasswordAction,
    GetCompanyUsersAction,
    DeleteCompanyUserAction
};
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\UI\API\Requests\{
    CheckAthleteRequest,
    CheckEmailAvailabilityRequest,
    CreateAdminRequest,
    DeleteAgentRequest,
    DeleteUserRequest,
    DisableUserAccountRequest,
    FindUserByIdRequest,
    ForgotPasswordRequest,
    GetAllUsersRequest,
    GetAuthenticatedUserRequest,
    RegisterUserRequest,
    ResetPasswordRequest,
    UpdateUserRequest,
    DisableAccountRequest,
    MagicLinkRequest,
    CheckPasswordSetRequest,
    ChangePasswordRequest,
    GetCompanyUsersRequest,
    DeleteCompanyUserRequest
};
use App\Containers\AppSection\User\UI\API\Transformers\{
    UserPrivateProfileTransformer,
    UserTransformer
};
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function registerUser(RegisterUserRequest $request): array
    {
        $user = app(RegisterUserAction::class)->run($request);
        return $this->transform($user, UserTransformer::class);
    }

    public function createAdmin(CreateAdminRequest $request): array
    {
        $admin = app(CreateAdminAction::class)->run($request);
        return $this->transform($admin, UserTransformer::class);
    }

    public function updateUser(UpdateUserRequest $request): array
    {
        $user = app(UpdateUserAction::class)->run($request);
        return $this->transform($user, UserTransformer::class);
    }

    public function deleteUser(DeleteUserRequest $request): JsonResponse
    {
        app(DeleteUserAction::class)->run($request);
        return $this->noContent();
    }

    public function deleteAgent(DeleteAgentRequest $request): JsonResponse
    {
        app(DeleteAgentAction::class)->run($request);
        return $this->noContent();
    }

    public function getAllUsers(GetAllUsersRequest $request): array
    {
        $users = app(GetAllUsersAction::class)->run();
        return $this->transform($users, UserTransformer::class);
    }

    public function getAllClients(GetAllUsersRequest $request): array
    {
        $users = app(GetAllClientsAction::class)->run();
        return $this->transform($users, UserTransformer::class);
    }

    public function getAllAdmins(GetAllUsersRequest $request): array
    {
        $users = app(GetAllAdminsAction::class)->run();
        return $this->transform($users, UserTransformer::class);
    }

    public function findUserById(FindUserByIdRequest $request): array
    {
        $user = app(FindUserByIdAction::class)->run($request);
        return $this->transform($user, UserTransformer::class);
    }

    public function getAuthenticatedUser(GetAuthenticatedUserRequest $request): array
    {
        $user = app(GetAuthenticatedUserAction::class)->run();
        return $this->transform($user, UserPrivateProfileTransformer::class);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        app(ResetPasswordAction::class)->run($request);
        return $this->noContent(204);
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        app(ForgotPasswordAction::class)->run($request);
        return $this->noContent(202);
    }

    public function disableUserAccount(DisableUserAccountRequest $request): JsonResponse
    {
        app(DisableUserAccountAction::class)->run($request);
        return $this->noContent(202);
    }

    public function disableAccount(DisableAccountRequest $request): JsonResponse
    {
        app(DisableAccountAction::class)->run($request);
        return $this->noContent(202);
    }

    public function checkEmailAvailability(CheckEmailAvailabilityRequest $request): JsonResponse
    {
        $result = app(CheckEmailAvailabilityAction::class)->run($request);
        return $this->json($result);
    }

    public function checkAthlete(CheckAthleteRequest $request): JsonResponse
    {
        $result = app(CheckAthleteAction::class)->run($request);
        return $this->json($result);
    }

    public function MagicLink(MagicLinkRequest $request) {
        app(MagicLinkAction::class)->run($request);
        return $this->noContent(204);
    }

    public function CheckPasswordSet(CheckPasswordSetRequest $request) {
        $checkPasswordSet = app(CheckPasswordSetAction::class)->run($request->user()->id);
        return $this->json([
            'empty_password' => !$checkPasswordSet
        ]);
    }

    public function ChangePassword(ChangePasswordRequest $request) {
        app(ChangePasswordAction::class)->run($request);
        return $this->noContent(200);
    }

    /**
     * @param GetCompanyUsersRequest $request
     * @return array
     * @throws \Apiato\Core\Exceptions\InvalidTransformerException
     */
    public function getCompanyUsers(GetCompanyUsersRequest $request)
    {
        $users = app(GetCompanyUsersAction::class)->run($request);
        return $this->transform($users, UserTransformer::class);
    }

    public function deleteCompanyUser(DeleteCompanyUserRequest $request)
    {
        app(DeleteCompanyUserAction::class)->run($request);
        return $this->noContent();
    }
}
