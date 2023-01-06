<?php

namespace App\Containers\AppSection\Deal\Actions;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Containers\AppSection\Deal\Exceptions\MissingInputException;
use App\Containers\AppSection\Deal\Models\Deal;
use App\Containers\AppSection\Deal\Tasks\CreateDealTask;
use App\Containers\AppSection\Deal\Tasks\MapRequestToDealTask;
use App\Containers\AppSection\System\Enums\BorrowerType;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class CreateDealAction extends Action
{
    use HashIdTrait;

    public function run(Request $request): Deal
    {
        $crtUser = $request->user();
        $userId = $crtUser->id;
        if(($request->user_type == BorrowerType::ATHLETE) && $crtUser->isAgent())
        {
            if(!$request->has('athlete') || !is_array($request->athlete))
            {
                throw new MissingInputException('missing ahtlete data');
            }
            $athleteData = $request->athlete;
            if(!isset($athleteData['id']))
            {
                throw new MissingInputException('missing ahtlete id');
            }

            $userId = $this->decode($athleteData['id']);
        }

        $deal = app(MapRequestToDealTask::class)->run($request->all());
        $deal['status'] = DealStatus::NOT_STARTED;
        $deal['reason'] = StatusReason::DRAFT;
        $deal['user_id'] = $userId;
        $deal['created_by'] = $request->user()->id;
        $deal['submited_data'] = $request->all();

        $dealObj = app(CreateDealTask::class)->run($deal);
        // update deal index
        app(SetDealIndexFieldsAction::class)->run($dealObj);

        return $dealObj;
    }
}
