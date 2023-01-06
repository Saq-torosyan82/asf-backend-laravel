<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\UserProfile\Tasks\GetCountriesStatsTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Auth;

class GetDealsByCountryAction extends Action
{
    public function run()
    {
        $user = Auth::user();
        $userId = !$user->hasAdminRole() ? Auth::user()->id : null;
        return app(GetCountriesStatsTask::class)->run($userId);
    }
}
