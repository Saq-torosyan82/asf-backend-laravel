<?php

namespace App\Containers\AppSection\Upload\Actions;

use App\Containers\AppSection\Upload\Enums\UserDocumetStatus;
use App\Containers\AppSection\Upload\Tasks\FindUserDocumentByTypeTask;
use App\Containers\AppSection\Upload\Tasks\CreateUserDocumentTask;
use App\Containers\AppSection\Upload\Enums\UserDocumetType;
use App\Containers\AppSection\Upload\Enums\UploadType;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use App\Ship\Exceptions\ConflictException;

class UploadDocumentAction extends Action
{
    public function run(Request $request, $userId)
    {
        if (empty($userId)) {
            throw new ConflictException('The user is invalid!');
        }

        if ($request->document_type == UploadType::CONSENT) {
            return app(UploadConsentSubAction::class)->run($request, $userId);
        }

        if (!UserDocumetType::hasValue($request->document_type)) {
            throw new ConflictException('The document type is invalid!');
        }


        if (!UserDocumetType::isMultipleDocument($request->document_type)) {
            $existingDocument = app(FindUserDocumentByTypeTask::class)->run($userId, $request->document_type);
            if ($existingDocument != null) {
                throw new ConflictException('This type of document is already uploaded by this user!');
            }
        }


        if (is_array($request->file)) {
            foreach ($request->file as $file) {
                $upload = app(UploadFileSubAction::class)->run($file, UploadType::DOCUMENT, $userId);

                app(CreateUserDocumentTask::class)->run(
                    [
                        'user_id' => $userId,
                        'upload_id' => $upload->id,
                        'is_verified' => UserDocumetStatus::PENDING,
                        'type' => $request->document_type
                    ]
                );
            }
        } else {
            $upload = app(UploadFileSubAction::class)->run($request->file('file'), UploadType::DOCUMENT, $userId);

            app(CreateUserDocumentTask::class)->run(
                [
                    'user_id' => $userId,
                    'upload_id' => $upload->id,
                    'is_verified' => UserDocumetStatus::PENDING,
                    'type' => $request->document_type
                ]
            );
        }

        return $upload->uuid;
    }
}
