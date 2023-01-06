<?php

namespace App\Containers\AppSection\Communication\UI\API\Controllers;

use App\Containers\AppSection\Communication\Actions\{
    AddMessageAction,
    DeleteAttachmentsAction,
    GetMessagesAction,
    GetParticipantsForDealAction,
    CreateAction,
    FindByIdAction,
    GetAllAction,
    GetQuestionTypesAction,
    UpdateAction,
    DeleteAction,
    UploadAttachementsAction
};
use App\Containers\AppSection\Communication\UI\API\Transformers\MessagesTransformer;
use App\Containers\AppSection\Communication\UI\API\Requests\{
    DeleteAttachmentsRequest,
    CreateDealTypeRequest,
    CreateServiceTypeRequest,
    DeleteRequest,
    GetAllRequest,
    FindByIdRequest,
    AddMessageRequest,
    GetMessagesRequest,
    GetParticipantsForDealRequest,
    GetQuestionTypesRequest,
    UpdateRequest,
    UploadAttachementsRequest
};
use App\Containers\AppSection\Communication\UI\API\Transformers\CommunicationTransformer;
use App\Ship\Parents\Controllers\ApiController;
use App\Containers\AppSection\Communication\Enums\CommunicationType;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function createDealType(CreateDealTypeRequest $request)
    {
        $communication = app(CreateAction::class)->run($request, CommunicationType::DEALS);
        return $this->transform($communication, CommunicationTransformer::class);
    }

    public function createServiceType(CreateServiceTypeRequest $request)
    {
        $communication = app(CreateAction::class)->run($request, CommunicationType::SERVICE);
        return $this->transform($communication, CommunicationTransformer::class);
    }

    public function findById(FindByIdRequest $request)
    {
        $communication = app(FindByIdAction::class)->run($request);
        return $this->transform($communication, CommunicationTransformer::class);
    }

    public function getAll(GetAllRequest $request): array
    {
        $communications = app(GetAllAction::class)->run($request);
        return $this->transform($communications, CommunicationTransformer::class);
    }

    public function update(UpdateRequest $request): array
    {
        $communication = app(UpdateAction::class)->run($request);
        return $this->transform($communication, CommunicationTransformer::class);
    }

    public function delete(DeleteRequest $request): JsonResponse
    {
        app(DeleteAction::class)->run($request);
        return $this->noContent();
    }

    public function getParticipantsForDeal(GetParticipantsForDealRequest $request) {
        $result = app(GetParticipantsForDealAction::class)->run($request);
        return new JsonResponse($result);
    }

    public function getMessages(GetMessagesRequest $request)
    {
        $messages = app(GetMessagesAction::class)->run($request);
        return $this->transform($messages, MessagesTransformer::class);
    }

    public function addMessage(AddMessageRequest $request)
    {
        $message = app(AddMessageAction::class)->run($request);
        return $this->transform($message, MessagesTransformer::class);
    }

    public function attachementsUpload(UploadAttachementsRequest $request): JsonResponse
    {
        $uploadRes = app(UploadAttachementsAction::class)->run($request);
        return new JsonResponse(['attachements' => $uploadRes]);
    }

    public function getQuestionTypes(GetQuestionTypesRequest $request): JsonResponse
    {
        $questions = app(GetQuestionTypesAction::class)->run($request);
        return new JsonResponse($questions);
    }

    public function deleteAttachments(DeleteAttachmentsRequest $request) {
        app(DeleteAttachmentsAction::class)->run($request);
        return $this->noContent();
    }
}
