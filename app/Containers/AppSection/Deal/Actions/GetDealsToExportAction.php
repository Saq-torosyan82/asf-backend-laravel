<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Actions\GetCurrentDealsAction;
use App\Containers\AppSection\Deal\UI\API\Requests\ExportDealsRequest;
use App\Ship\Parents\Actions\Action;

class GetDealsToExportAction extends Action
{
    public function run(ExportDealsRequest $request)
    {
       switch ($request->type) {
           case 'missed':
               $deals = app(GetLenderMissedDealsAction::class)->run($request, false);
               break;
           case 'current':
               $deals = app(GetCurrentDealsAction::class)->run($request, false);
               break;
           case 'quotes':
               $deals = app(GetQuotesAction::class)->run($request, false);
               break;
           default:
               $deals = app(GetDealsAction::class)->run($request, false);
       }

       return $deals;
    }
}
