<?php

namespace App\Containers\AppSection\Authentication\Actions;

use App\Containers\AppSection\Authentication\UI\API\Requests\ValidateLoginTokenRequest;
use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Containers\AppSection\UserProfile\Tasks\GetAuthenticatedUserTypeTask;
use App\Containers\AppSection\UserProfile\Tasks\GetBorrowerTypeTask;
use App\Ship\Exceptions\AuthenticationException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\ConflictException;
use App\Ship\Exceptions\BadRequestException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Exceptions\Exception;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class ValidateLoginTokenAction extends Action
{
    public function run(ValidateLoginTokenRequest $request)
    {
        try {
            $user = app(FindUserByIdTask::class)->run($request->uid);
            if(strcmp($request->token, $user->login_token) != 0) {
                // return ['message' => 'Token is invalid', 'status' => 401];
                throw new AuthenticationException('Token is invalid');
            }

            $interval = Carbon::now()->diffAsCarbonInterval(Carbon::create($user->login_token_expire), false);
            if($interval->invert) {
                // return ['message' => 'Token is expired', 'status' => 409];
                throw new ConflictException('Token is expired');
            }

            $access_token = $user->createToken('AutoLogin')->accessToken;

            app(UpdateUserTask::class)->run([
                'login_token' => null,
                'login_token_expire' => null,
                'email_verified_at' => Carbon::now()
            ], $user->id);

            try {
                $userType = app(GetAuthenticatedUserTypeTask::class)->run($user);
            } catch (Exception $e) {
                // silently ignore
                die($e->getMessage());
            }

            $is_onboarderd = $userType != null;

            return [
                'token_type' => 'Bearer',
                'expires_in' => config('appSection-authentication.login_token_expiration') * 60,
                'access_token' => $access_token,
                'refresh_token' => '',
                'redirect_after' => '',
                'is_onboarderd' => $is_onboarderd
            ];
        } catch (NotFoundException $e) {
            // return ['message' => 'Token is invalid', 'status' => 400];
            throw new BadRequestException($e->getMessage());
        }
    }
}
