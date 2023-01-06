<?php

namespace App\Containers\AppSection\Financial\Actions;

use App\Containers\AppSection\Financial\Enums\FinancialDocumentsStatus;
use App\Containers\AppSection\Financial\Tasks\CreateOrUpdateFinancialDataTask;
use App\Containers\AppSection\Financial\Tasks\GetActualFinancialTask;
use App\Containers\AppSection\Financial\Tasks\GetUserFinancialDocumentsTask;
use App\Containers\AppSection\Financial\Tasks\UpdateDocumentsStatusTask;
use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileFieldTask;
use App\Containers\AppSection\Financial\Tasks\FindFinancialsTask;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Ship\Exceptions\ConflictException;
use App\Ship\Exceptions\NotAuthorizedResourceException;
use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Actions\Action;

class CreateOrUpdateFinancialDataAction extends Action
{
    public function run(Request $request)
    {
        $club = app(FindUserProfileFieldTask::class)->run($request->user()->id, Group::PROFESSIONAL, Key::CLUB);

        if ($club == null) {
            throw new ConflictException("No professional club assigned");
        }

        $financial = app(GetActualFinancialTask::class)->run($club->value);

        if (!isset($financial) || $financial == null) {
            throw new ConflictException("Actual Financial not found");
        }

        if ($financial->is_blocked == 1) {
            throw new NotAuthorizedResourceException("The financial is blocked!");
        }
        $docs = app(GetUserFinancialDocumentsTask::class)->run(null, $club->value, $request->section_id);
        if ($docs) {
            foreach ($docs as $doc) {
                if ($doc->status != FinancialDocumentsStatus::REJECTED) {
                    app(UpdateDocumentsStatusTask::class)->run($doc->id, ['status' => FinancialDocumentsStatus::PENDING]);
                }
            }
        }
        $currencyTo = $financial->currency;
        $currencyFrom = isset($request->selected_currency) ? $request->selected_currency : $currencyTo;

        return app(CreateOrUpdateFinancialDataTask::class)->run($financial->id, $request->data, $currencyFrom, $currencyTo);
    }
}
