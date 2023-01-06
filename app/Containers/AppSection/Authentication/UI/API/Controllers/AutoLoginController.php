<?php

namespace App\Containers\AppSection\Authentication\UI\API\Controllers;

use App\Containers\AppSection\Authentication\UI\API\Requests\ValidateLoginTokenRequest;
use App\Containers\AppSection\Authentication\Actions\ValidateLoginTokenAction;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class AutoLoginController extends ApiController
{
    public function ValidateLoginToken(ValidateLoginTokenRequest $request): JsonResponse
    {
        $response = app(ValidateLoginTokenAction::class)->run($request);
        return new JsonResponse($response);
    }
}
