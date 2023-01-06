<?php

namespace App\Containers\AppSection\Upload\Actions;

use App\Containers\AppSection\Deal\Data\Repositories\DealRepository;
use App\Containers\AppSection\Upload\Exceptions\DealDeniedException;
use App\Containers\AppSection\Upload\Exceptions\DealMissingException;
use App\Containers\AppSection\Upload\Exceptions\DealNotFoundException;
use App\Containers\AppSection\Upload\Tasks\CreateUploadTask;
use App\Containers\AppSection\Upload\Tasks\UploadFileTask;
use App\Containers\AppSection\Upload\Enums\UploadType;
use App\Ship\Parents\Actions\SubAction;
use App\Ship\Parents\Requests\Request;
use Illuminate\Http\UploadedFile;
use App\Ship\Exceptions\ConflictException;
use Illuminate\Support\Facades\Auth;

class UploadConsentSubAction extends SubAction
{
    protected DealRepository $repository;

    public function __construct(DealRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(Request $request, int $userId)
    {
        $input = $request->all();
        if (!isset($input['deal_id']) || !$input['deal_id']) {
            throw new DealMissingException();
        }

        // get the deal
        $deal = $this->repository->findByField('id', $input['deal_id'])->first();
        if (is_null($deal)) {
            throw new DealNotFoundException();
        }

        // check if the user is curren user
        if ($deal->user_id != $userId) {
            throw new DealDeniedException();
        }

        // SEEMEk: check if has alredy a consent and delete the old one
        $consent_data = $deal->consent_data;

        try {
            $upload = app(UploadFileSubAction::class)->run($request->file('file'), $input['document_type'], $userId);
            $consent_data['consentFile'] = $upload->uuid;
            $this->repository->update(['consent_data' => $consent_data], $input['deal_id']);
        } catch (\Exception $e) {
            throw $e;
        }

        return $upload->uuid;
    }
}
