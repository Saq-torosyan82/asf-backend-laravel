<?php

namespace App\Containers\AppSection\Authentication\Actions;

use App\Containers\AppSection\Authentication\Exceptions\RefreshTokenMissedException;
use App\Containers\AppSection\Authentication\Exceptions\UserInactiveException;
use App\Containers\AppSection\Authentication\Tasks\CallOAuthServerTask;
use App\Containers\AppSection\Authentication\Tasks\MakeRefreshCookieTask;
use App\Containers\AppSection\Authentication\UI\API\Requests\ProxyRefreshRequest;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\DB;
use Lcobucci\JWT\Parser;
use Illuminate\Support\Facades\Request;

class ProxyRefreshForWebClientAction extends Action
{
    public function run(ProxyRefreshRequest $request): array
    {
        $sanitizedData = $request->sanitizeInput([
            'refresh_token',
        ]);

        $sanitizedData['refresh_token'] = $sanitizedData['refresh_token'] ?: Request::cookie('refreshToken');
        $sanitizedData['client_id'] = config('appSection-authentication.clients.web.id');
        $sanitizedData['client_secret'] = config('appSection-authentication.clients.web.secret');
        $sanitizedData['grant_type'] = 'refresh_token';
        $sanitizedData['scope'] = '';

        if (!$sanitizedData['refresh_token']) {
            throw new RefreshTokenMissedException();
        }

        $responseContent = app(CallOAuthServerTask::class)->run($sanitizedData, $request->headers->get('accept-language'));
        $this->checkActiveStatus($responseContent);
        $refreshCookie = app(MakeRefreshCookieTask::class)->run($responseContent['refresh_token']);

        return [
            'response_content' => $responseContent,
            'refresh_cookie' => $refreshCookie,
        ];
    }

    private function checkActiveStatus($response): void
    {
        $user = $this->extractUserFromAuthServerResponse($response);

        if(!$user->is_active) {
            throw new UserInactiveException();
        }

        if(!$user->is_locked) {
            throw new UserLockedException();
        }
    }

    private function extractUserFromAuthServerResponse($response)
    {
        $tokenId = app(Parser::class)->parse($response['access_token'])->claims()->get('jti');
        $userAccessRecord = DB::table('oauth_access_tokens')->find($tokenId);
        return User::find($userAccessRecord->user_id);
    }
}
