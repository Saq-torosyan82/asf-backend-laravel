<?php

namespace App\Containers\AppSection\Upload\Actions;

use App\Containers\AppSection\Upload\Tasks\GetAllUserDocumentsTask;
use App\Containers\AppSection\Deal\Enums\ContractType;
use App\Containers\AppSection\Upload\Tasks\GetBorrowerDocumentsTask;
use App\Containers\AppSection\Upload\Tasks\GetLenderTermSheetsTask;
use App\Ship\Exceptions\ConflictException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetMyDocumentsAction extends Action
{
    public function run(Request $request)
    {
        $contractType = $request->contract_type;
        if ($contractType != null && !ContractType::hasValue($contractType)) {
            throw new ConflictException("The Contract Type is invalid");
        }


//        $user = \Auth::user();
//        var_dump($request->user());
        // get personal documents
        if ($request->user()->isLender()) {
            $personal = app(GetLenderTermSheetsAction::class)->run($request->user()->id);
        } else {
            if ($contractType != null && $contractType === ContractType::PLAYER_TRANSFER) {
                $personal = app(GetBorrowerDocumentsTask::class)->run($request->user()->id, false);
            } else {
                $personal = app(GetBorrowerDocumentsTask::class)->run($request->user()->id, true);
            }
        }

        // get deals documents


//        $data = [
//            'personal' => [],
//            'deals' => []
//        ];
//
//        if($contractType != null && $contractType === ContractType::PLAYER_TRANSFER) {
//            return [
//                'personal' => app(GetBorrowerDocumentsTask::class)->run($request->user()->id, false),
//                'deals' => app(GetBorrowerDocumentsTask::class)->run($request->user()->id, false),
//            ];
//            //$personal = app(GetAllUserDocumentsTask::class)->run($request->user()->id, false);
//        }

        return [
            'personal' => $personal,
            'deals' => app(GetBorrowerDocumentsTask::class)->run($request->user()->id, true),
        ];

        return app(GetAllUserDocumentsTask::class)->run($request->user()->id, true);
    }
}
