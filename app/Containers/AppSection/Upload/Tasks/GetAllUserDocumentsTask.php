<?php

namespace App\Containers\AppSection\Upload\Tasks;

use App\Containers\AppSection\Upload\Data\Repositories\UserDocumentRepository;
use App\Containers\AppSection\Upload\Enums\UserDocumetType;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Tasks\Task;

class GetAllUserDocumentsTask extends Task
{
    protected UserDocumentRepository $repository;

    public function __construct(UserDocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $userId, bool $exceptPlayerTransfer)
    {
        $all_documents = UserDocumetType::getValues();

        // get all user documents
        $res = $this->repository->findWhere(
            [
                'user_id' => $userId
            ]
        );

        $userDocuments = [];
        foreach ($res as $row) {
            $userDocuments[$row->type][] = $row;
        }

        $data = [];
        foreach ($all_documents as $type) {
            if ($exceptPlayerTransfer && UserDocumetType::isPlayerTransferKey($type)) {
                continue;
            }

            $id = '';
            $url = '';
            $file_type = '';
            $file_name = '';
            $file_size = '';
            $is_verified = false;

            $doc = [
                'type' => $type,
                'label' => UserDocumetType::getDescription($type),
                'is_multiple' => UserDocumetType::isMultipleDocument($type),
            ];

            $url_multiple = [];
            if (isset($userDocuments[$type])) {
                if (UserDocumetType::isMultipleDocument($type)) {
                    foreach ($userDocuments[$type] as $row) {
                        $url_multiple[] = [
                            'id' => $row->uuid,
                            'is_verified' => $row->is_verified,
                            'url' => downloadUrl($row->Upload->uuid),
                            'file_type' => $row->Upload->file_mime,
                            'file_name' => $row->Upload->file_name,
                            'file_size' => $row->Upload->file_size,
                        ];
                    }
                } else {
                    $id = $userDocuments[$type][0]->uuid;
                    $is_verified = $userDocuments[$type][0]->is_verified;
                    $file_name = $userDocuments[$type][0]->Upload->file_name;
                    $file_size = $userDocuments[$type][0]->Upload->file_size;
                    $url = downloadUrl($userDocuments[$type][0]->Upload->uuid);
                    $file_type = $userDocuments[$type][0]->Upload->file_mime;
                }
            }

            if (!UserDocumetType::isMultipleDocument($type)) {
                $doc['id'] = $id;
                $doc['is_verified'] = $is_verified;
                $doc['url'] = $url;
                $doc['file_type'] = $file_type;
                $doc['file_name'] = $file_name;
                $doc['file_size'] = $file_size;
            } else {
                $doc['data'] = $url_multiple;
            }

            $data[] = $doc;
        }

        return $data;
    }
}
