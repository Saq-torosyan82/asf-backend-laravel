<?php

namespace App\Containers\AppSection\Financial\UI\API\Controllers;

use App\Containers\AppSection\Financial\Actions\CreateOrUpdateFinancialDataAction;
use App\Containers\AppSection\Financial\Actions\DeleteFinancialDocumentAction;
use App\Containers\AppSection\Financial\Actions\GetDataForSnapshotAction;
use App\Containers\AppSection\Financial\Actions\GetUserFinancialDocumentsAction;
use App\Containers\AppSection\Financial\Actions\GetUserFinancialsAction;
use App\Containers\AppSection\Financial\Actions\GetUserFinancialsDataAction;
use App\Containers\AppSection\Financial\Actions\SubmitFinancialDocumentsAction;
use App\Containers\AppSection\Financial\Actions\UpdateDocumentsStatusAction;
use App\Containers\AppSection\Financial\Actions\UploadFinancialDocumentsAction;
use App\Containers\AppSection\Financial\UI\API\Requests\CreateFinancialRequest;
use App\Containers\AppSection\Financial\UI\API\Requests\CreateOrUpdateFinancialDataRequest;
use App\Containers\AppSection\Financial\UI\API\Requests\DeleteFinancialDocumentRequest;
use App\Containers\AppSection\Financial\UI\API\Requests\DeleteFinancialRequest;
use App\Containers\AppSection\Financial\UI\API\Requests\GetAllFinancialsRequest;
use App\Containers\AppSection\Financial\UI\API\Requests\FindFinancialByIdRequest;
use App\Containers\AppSection\Financial\UI\API\Requests\GetDataForSnapshotRequest;
use App\Containers\AppSection\Financial\UI\API\Requests\GetFinancialDocumentsRequest;
use App\Containers\AppSection\Financial\UI\API\Requests\GetUserFinancialsDataRequest;
use App\Containers\AppSection\Financial\UI\API\Requests\SubmitFinancialDocumentsRequest;
use App\Containers\AppSection\Financial\UI\API\Requests\UpdateFinancialDocumentsRequest;
use App\Containers\AppSection\Financial\UI\API\Requests\UpdateFinancialRequest;
use App\Containers\AppSection\Financial\UI\API\Requests\SaveFinancialDataRequest;
use App\Containers\AppSection\Financial\UI\API\Requests\UploadDocumentsFinancialRequest;
use App\Containers\AppSection\Financial\UI\API\Transformers\FinancialDocumentTransformer;
use App\Containers\AppSection\Financial\UI\API\Transformers\FinancialTransformer;
use App\Containers\AppSection\Financial\Actions\CreateFinancialAction;
use App\Containers\AppSection\Financial\Actions\GetAllFinancialsAction;
use App\Containers\AppSection\Financial\Actions\UpdateFinancialAction;
use App\Containers\AppSection\Financial\Actions\DeleteFinancialAction;
use App\Containers\AppSection\Financial\Actions\SaveFinancialDataAction;
use App\Ship\Parents\Controllers\ApiController;
use App\Ship\Parents\Requests\Request;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function createFinancial(CreateFinancialRequest $request): JsonResponse
    {
        $financial = app(CreateFinancialAction::class)->run($request);
        return $this->created($this->transform($financial, FinancialTransformer::class));
    }

    public function getUserFinancials(GetAllFinancialsRequest $request): JsonResponse
    {
        $financials = app(GetUserFinancialsAction::class)->run($request);
        return new JsonResponse($financials);
    }

    public function getDataForSnapshot(GetDataForSnapshotRequest $request): JsonResponse
    {
        $data = app(GetDataForSnapshotAction::class)->run($request);
        return new JsonResponse($data);
    }

    public function updateFinancial(UpdateFinancialRequest $request): array
    {
        $financial = app(UpdateFinancialAction::class)->run($request);
        return $this->transform($financial, FinancialTransformer::class);
    }

    public function deleteFinancial(DeleteFinancialRequest $request): JsonResponse
    {
        app(DeleteFinancialAction::class)->run($request);
        return $this->noContent();
    }

    public function SaveFinancialData(SaveFinancialDataRequest $request) {
        app(SaveFinancialDataAction::class)->run($request);
        return $this->noContent();
    }

    public function CreateOrUpdateFinancialData(CreateOrUpdateFinancialDataRequest $request) {
         app(CreateOrUpdateFinancialDataAction::class)->run($request);
         return $this->noContent();
    }

    public function getUserFinancialDocuments(GetFinancialDocumentsRequest $request)
    {
        $documents = app(GetUserFinancialDocumentsAction::class)->run($request);
        return new JsonResponse($documents);
    }

    public function updateFinancialDocumentsStatus(UpdateFinancialDocumentsRequest $request)
    {
        app(UpdateDocumentsStatusAction::class)->run($request);
        return $this->noContent();
    }

    public function getClubFinancials(GetFinancialDocumentsRequest $request)
    {
        $financials = app(GetUserFinancialsAction::class)->run($request);
        return new JsonResponse($financials);
        return $this->transform($financials, FinancialTransformer::class);
    }


    public function getUserFinancialDocuments2(GetFinancialDocumentsRequest $request)
    {
        $documents = app(GetUserFinancialDocumentsAction::class)->run($request);
        return new JsonResponse($documents);
    }

    // SEEMEk: change method name !!!!
    public function updateFinancialDocumentsStatus2(GetFinancialDocumentsRequest $request)
    {
        // SEEMEk: dummy method
        return $this->noContent();
    }

    public function uploadFinancialDocuments(UploadDocumentsFinancialRequest $request) {
        $docs = app(UploadFinancialDocumentsAction::class)->run($request);
        return new JsonResponse($docs);
    }

    public function submitFinancialDocuments(SubmitFinancialDocumentsRequest $request) {
        $docs = app(SubmitFinancialDocumentsAction::class)->run($request);
        return new JsonResponse($docs);
    }

    public function deleteFinancialDocument(DeleteFinancialDocumentRequest $request): JsonResponse
    {
        app(DeleteFinancialDocumentAction::class)->run($request);
        return $this->noContent();
    }


}
