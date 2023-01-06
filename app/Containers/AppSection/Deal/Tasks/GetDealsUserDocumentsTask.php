<?php

namespace App\Containers\AppSection\Deal\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Deal\Models\Deal;
use App\Containers\AppSection\Upload\Data\Repositories\UserDocumentRepository;
use App\Containers\AppSection\Upload\Enums\UserDocumetType;
use App\Containers\AppSection\Upload\Tasks\GetRequiredUserDocumentsTask;
use App\Ship\Parents\Tasks\Task;

class GetDealsUserDocumentsTask extends Task
{
    use HashIdTrait;

    protected UserDocumentRepository $repository;

    public function __construct(UserDocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(Deal $deal)
    {
        $contract_type = $deal->criteria_data['contract_type'];
        $requiredDocuments = app(GetRequiredUserDocumentsTask::class)->run($contract_type);

        $uploadedDocuments = [];
        $res = $this->repository->where('user_id', $deal->user_id)->get();
        foreach ($res as $row) {
            if (!isset($requiredDocuments[$row->type])) {
                continue;
            }

            $uploadedDocuments[$row->id] = $row;
        }

        if (!is_array($deal->user_documents) || !count($deal->user_documents)) {
            return [];
        }

        $dealDocuments = [];
        foreach ($deal->user_documents as $key => $row) {
            $is_verified = isset($row['is_verified']) ? $row['is_verified'] : 0;
            if (isset($row['is_multiple']) && $row['is_multiple'] && isset($row['data'])) {
                foreach ($row['data'] as $rrow) {
                    $is_verified = isset($rrow['is_verified']) ? $rrow['is_verified'] : 0;
                    if (isset($uploadedDocuments[$rrow['upload_id']])) {
                        $is_verified = $uploadedDocuments[$rrow['upload_id']];
                    }

                    $dealDocuments[] = [
                        'type' => $key,
                        'label' => UserDocumetType::getDescriptionByType($key, $contract_type),
                        'is_multiple' => $row['is_multiple'],
                        'id' => $this->encode($rrow['id']),
                        'url' => downloadUrl($rrow['upload_uuid']),
                        'is_verified' => $is_verified,
                        'upload_date' => isset($rrow['upload_date']) ? $rrow['upload_date'] : $deal->created_at->format(
                            'Y-m-d'
                        )
                    ];
                }
            } else {
                if (isset($uploadedDocuments[$row['upload_id']])) {
                    $is_verified = $uploadedDocuments[$row['upload_id']];
                }

                $dealDocuments[] = [
                    'type' => $key,
                    'label' => UserDocumetType::getDescriptionByType($key, $contract_type),
                    'is_multiple' => $row['is_multiple'],
                    'id' => $this->encode($row['id']),
                    'url' => downloadUrl($row['upload_uuid']),
                    'is_verified' => $is_verified,
                    'upload_date' => isset($row['upload_date']) ? $row['upload_date'] : $deal->created_at->format(
                        'Y-m-d'
                    )
                ];
            }
        }

        return $dealDocuments;
    }
}
