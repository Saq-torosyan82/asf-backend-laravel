<?php

namespace App\Containers\AppSection\Payment\Actions;

use App\Containers\AppSection\Payment\Tasks\GetDealsPaymentsTask;
use App\Containers\AppSection\Payment\Tasks\GetOverdueDealsPaymentsTask;
use App\Ship\Parents\Requests\Request;
use App\Containers\AppSection\System\Enums\Currency;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Auth;

class GetDealsPaymentsAction extends Action
{
    public function run(Request $request)
    {
        $user = Auth::user();
        $userId = !$user->hasAdminRole() ? $user->id : null;
        $currencyTo = $request->selected_currency ? $request->selected_currency : Currency::getDescription(Currency::GBP);

        return [
            'all' => app(GetDealsPaymentsTask::class)->run($userId, $user->isLender(),$currencyTo),
            'overdue' => app(GetOverdueDealsPaymentsTask::class)->run($userId, $user->isLender(),$currencyTo)
        ];
    }
}
