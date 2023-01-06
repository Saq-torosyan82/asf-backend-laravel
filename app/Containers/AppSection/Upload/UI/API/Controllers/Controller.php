<?php

namespace App\Containers\AppSection\Upload\UI\API\Controllers;

use App\Containers\AppSection\Upload\Actions\GetUserPersonalDocumentsAction;
use App\Containers\AppSection\Upload\Actions\UploadAgentAvatarAction;
use App\Containers\AppSection\Upload\Actions\UploadAvatarStrategyAction;
use App\Containers\AppSection\Upload\UI\API\Requests\CreateUploadRequest;
use App\Containers\AppSection\Upload\UI\API\Requests\DeleteUploadRequest;
use App\Containers\AppSection\Upload\UI\API\Requests\GetAllUploadsRequest;
use App\Containers\AppSection\Upload\UI\API\Requests\FindUploadByIdRequest;
use App\Containers\AppSection\Upload\UI\API\Requests\GetMyPersonalDocumentsRequest;
use App\Containers\AppSection\Upload\UI\API\Requests\GetUserPersonalDocumentsRequest;
use App\Containers\AppSection\Upload\UI\API\Requests\UpdateUploadRequest;
use App\Containers\AppSection\Upload\UI\API\Requests\DownloadRequest;
use App\Containers\AppSection\Upload\UI\API\Requests\GetMyDocumentsRequest;
use App\Containers\AppSection\Upload\UI\API\Requests\GetUserDocumentsRequest;
use App\Containers\AppSection\Upload\UI\API\Requests\DeleteMyDocumentRequest;
use App\Containers\AppSection\Upload\UI\API\Requests\DeleteUserDocumentRequest;
use App\Containers\AppSection\Upload\UI\API\Requests\UploadAvatarRequest;
use App\Containers\AppSection\Upload\UI\API\Requests\UploadDocumentRequest;
use App\Containers\AppSection\Upload\UI\API\Requests\UploadUserAvatarRequest;
use App\Containers\AppSection\Upload\UI\API\Requests\UploadUserDocumentRequest;
use App\Containers\AppSection\Upload\UI\API\Transformers\UploadTransformer;
use App\Containers\AppSection\Upload\UI\API\Transformers\UserDocumentTransformer;
use App\Containers\AppSection\Upload\Actions\CreateUploadAction;
use App\Containers\AppSection\Upload\Actions\FindUploadByIdAction;
use App\Containers\AppSection\Upload\Actions\GetAllUploadsAction;
use App\Containers\AppSection\Upload\Actions\UpdateUploadAction;
use App\Containers\AppSection\Upload\Actions\SoftDeleteUploadAction;
use App\Containers\AppSection\Upload\Actions\UploadAvatarAction;
use App\Containers\AppSection\Upload\Actions\DownloadUploadedFileAction;
use App\Containers\AppSection\Upload\Actions\GetMyDocumentsAction;
use App\Containers\AppSection\Upload\Actions\GetUserDocumentsAction;
use App\Containers\AppSection\Upload\Actions\DeleteUserDocumentAction;
use App\Containers\AppSection\Upload\Actions\UploadDocumentAction;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function createUpload(CreateUploadRequest $request): JsonResponse
    {
        $uploadId = app(CreateUploadAction::class)->run($request);
        return new JsonResponse(['id' => $uploadId]);
    }

    public function uploadAvatar(UploadAvatarRequest $request): JsonResponse
    {
        $uploadId = app(UploadAvatarStrategyAction::class)->run($request);
        return new JsonResponse(['id' => $uploadId]);
    }

    public function UploadUserAvatar(UploadUserAvatarRequest $request): JsonResponse
    {
        $uploadId = app(UploadAvatarStrategyAction::class)->run($request, $request->user_id);
        return new JsonResponse(['id' => $uploadId]);
    }


    public function findUploadById(FindUploadByIdRequest $request): array
    {
        $upload = app(FindUploadByIdAction::class)->run($request);
        return $this->transform($upload, UploadTransformer::class);
    }

    public function getAllUploads(GetAllUploadsRequest $request): array
    {
        $uploads = app(GetAllUploadsAction::class)->run($request);
        return $this->transform($uploads, UploadTransformer::class);
    }

    public function deleteUpload(DeleteUploadRequest $request): JsonResponse
    {
        app(SoftDeleteUploadAction::class)->run($request);
        return $this->noContent();
    }

    public function download(DownloadRequest $request)
    {
        return app(DownloadUploadedFileAction::class)->run($request);
    }

    public function GetMyDocuments(GetMyDocumentsRequest $request): JsonResponse
    {
        $userDocuments = app(GetUserDocumentsAction::class)->run($request, true);
//        $userDocuments = app(GetMyDocumentsAction::class)->run($request);
        return new JsonResponse($userDocuments);
    }

    public function GetMyPersonalDocuments(GetMyPersonalDocumentsRequest $request): JsonResponse
    {
        $userDocuments = app(GetUserPersonalDocumentsAction::class)->run($request->user(), $request->contract_type);
        return new JsonResponse($userDocuments);
    }

    public function GetUserDocuments(GetUserDocumentsRequest $request): JsonResponse
    {
        $userDocuments = app(GetUserDocumentsAction::class)->run($request, false);
        return new JsonResponse($userDocuments);
    }

    public function GetUserPersonalDocuments(GetUserPersonalDocumentsRequest $request): JsonResponse
    {
        $user = app(FindUserByIdTask::class)->run($request->user_id);
        $userDocuments = app(GetUserPersonalDocumentsAction::class)->run($user, $request->contract_type);
        return new JsonResponse($userDocuments);
    }

    public function DeleteMyDocument(DeleteMyDocumentRequest $request)
    {
        app(DeleteUserDocumentAction::class)->run($request);
        return $this->noContent();
    }

    public function DeleteUserDocument(DeleteUserDocumentRequest $request)
    {
        app(DeleteUserDocumentAction::class)->run($request);
        return $this->noContent();
    }

    public function UploadDocument(UploadDocumentRequest $request) {
        $uploadId = app(UploadDocumentAction::class)->run($request, $request->user()->id);
        return new JsonResponse(['id' => $uploadId]);
    }

    public function UploadUserDocument(UploadUserDocumentRequest $request) {
        $uploadId = app(UploadDocumentAction::class)->run($request, $request->user_id);
        return new JsonResponse(['id' => $uploadId]);
    }
}
