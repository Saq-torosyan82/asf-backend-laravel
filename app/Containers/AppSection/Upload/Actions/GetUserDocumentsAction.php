<?php

namespace App\Containers\AppSection\Upload\Actions;

use App\Containers\AppSection\Deal\Enums\ContractType;
use App\Containers\AppSection\Upload\Tasks\GetAllUserDocumentsTask;
use App\Containers\AppSection\Upload\Tasks\GetBorrowerDocumentsTask;
use App\Containers\AppSection\Upload\Tasks\GetLenderTermSheetsTask;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Exceptions\ConflictException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetUserDocumentsAction extends Action
{
    public function run(Request $request, $my_documents = true)
    {
        $contractType = $request->contract_type;
        if ($contractType != null && !ContractType::hasValue($contractType)) {
            throw new ConflictException("The Contract Type is invalid");
        }

        if ($my_documents) {
            $user = \Auth::user();

        } else {
            $user = app(FindUserByIdTask::class)->run($request->user_id);
        }

        // get personal documents
        $deals = [];
        if ($user->isLender()) {
            $personal = app(GetLenderTermSheetsAction::class)->run($user->id);
            $deals = app(GetLenderSignedContractsAction::class)->run($user->id);
        } else {
            $personal = app(GetBorrowerDocumentsTask::class)->run($user->id, $contractType);
            $deals = app(GetBorrowerSignedContractsAction::class)->run($user->id);
        }

//        if($contractType != null && $contractType === ContractType::PLAYER_TRANSFER) {
//            return [
//                'personal' => app(GetBorrowerDocumentsTask::class)->run($user->id, false),
//                'deals' => app(GetBorrowerDocumentsTask::class)->run($user->id, false),
//            ];
//            //$personal = app(GetAllUserDocumentsTask::class)->run($request->user()->id, false);
//        }

        return [
            'personal' => $personal,
            'deals' => $deals,
        ];

//        return app(GetAllUserDocumentsTask::class)->run($request->user()->id, true);
//        return app(GetAllUserDocumentsTask::class)->run($request->user_id, true);
    }
}
