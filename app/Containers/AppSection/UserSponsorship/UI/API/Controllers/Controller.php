<?php

namespace App\Containers\AppSection\UserSponsorship\UI\API\Controllers;

use App\Containers\AppSection\UserSponsorship\Actions\CreateMySponsorshipAction;
use App\Containers\AppSection\UserSponsorship\Actions\CreateUserSponsorshipAgentAction;
use App\Containers\AppSection\UserSponsorship\Actions\DeleteMySponsorshipAction;
use App\Containers\AppSection\UserSponsorship\Actions\DeleteUserSponsorshipAction;
use App\Containers\AppSection\UserSponsorship\Actions\DeleteUserSponsorshipAgentAction;
use App\Containers\AppSection\UserSponsorship\Actions\GetAllClubSponsorsAction;
use App\Containers\AppSection\UserSponsorship\Actions\GetAllSponsorshipOptionsAction;
use App\Containers\AppSection\UserSponsorship\Actions\GetAllUserSponsorshipsAction;
use App\Containers\AppSection\UserSponsorship\Actions\GetAllUserSponsorshipsAgentAction;
use App\Containers\AppSection\UserSponsorship\Actions\GetUserSponsorshipsAction;
use App\Containers\AppSection\UserSponsorship\UI\API\Requests\CreateMySponsorshipRequest;
use App\Containers\AppSection\UserSponsorship\UI\API\Requests\CreateUserSponsorshipAgentRequest;
use App\Containers\AppSection\UserSponsorship\UI\API\Requests\CreateUserSponsorshipRequest;
use App\Containers\AppSection\UserSponsorship\Actions\CreateUserSponsorshipAction;
use App\Containers\AppSection\UserSponsorship\UI\API\Requests\DeleteMySponsorshipRequest;
use App\Containers\AppSection\UserSponsorship\UI\API\Requests\DeleteUserSponsorshipAgentRequest;
use App\Containers\AppSection\UserSponsorship\UI\API\Requests\DeleteUserSponsorshipRequest;
use App\Containers\AppSection\UserSponsorship\UI\API\Requests\GetAllClubSponsorsRequest;
use App\Containers\AppSection\UserSponsorship\UI\API\Requests\GetAllSponsorshipOptionsRequest;
use App\Containers\AppSection\UserSponsorship\UI\API\Requests\GetAllUserSponsorshipsAgentRequest;
use App\Containers\AppSection\UserSponsorship\UI\API\Requests\GetAllUserSponsorshipsRequest;
use App\Containers\AppSection\UserSponsorship\UI\API\Requests\GetUserSponsorshipsRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function createMySponsorship(CreateMySponsorshipRequest $request): JsonResponse
    {
        app(CreateMySponsorshipAction::class)->run($request);
        return $this->noContent(201);
    }

    public function createUserSponsorship(CreateUserSponsorshipRequest $request): JsonResponse
    {
        app(CreateUserSponsorshipAction::class)->run($request);
        return $this->noContent(201);
    }

    // this method should be removed
    public function createUserSponsorshipAgent(CreateUserSponsorshipAgentRequest $request): JsonResponse
    {
        app(CreateUserSponsorshipAgentAction::class)->run($request);
        return $this->noContent(201);
    }

    public function getAllUserSponsorships(GetAllUserSponsorshipsRequest $request): JsonResponse
    {
        $result = app(GetAllUserSponsorshipsAction::class)->run($request);
        return $this->json($result);
    }

    public function getClubSponsors(GetAllClubSponsorsRequest $request): JsonResponse
    {
        $result = app(GetAllClubSponsorsAction::class)->run();
        return $this->json($result);
    }

    /**
     * get all user sponsorships
     * this method is for Admin
     *
     * @param GetUserSponsorshipsRequest $request
     * @return JsonResponse
     */
    public function getUserSponsorships(GetUserSponsorshipsRequest $request): JsonResponse
    {
        $result = app(GetUserSponsorshipsAction::class)->run($request);
        return $this->json($result);
    }

    public function deleteMySponsorship(DeleteMySponsorshipRequest $request): JsonResponse
    {
        app(DeleteMySponsorshipAction::class)->run($request);
        return $this->noContent(200);
    }

    public function deleteUserSponsorship(DeleteUserSponsorshipRequest $request): JsonResponse
    {
        app(DeleteUserSponsorshipAction::class)->run($request);
        return $this->noContent(200);
    }

    public function deleteUserSponsorshipAgent(DeleteUserSponsorshipAgentRequest $request): JsonResponse
    {
        app(DeleteUserSponsorshipAgentAction::class)->run($request);
        return $this->noContent(200);
    }

    public function getAllSponsorshipOptions(GetAllSponsorshipOptionsRequest $request): JsonResponse
    {
        $result = app(GetAllSponsorshipOptionsAction::class)->run($request);
        return $this->json($result);
    }
}
