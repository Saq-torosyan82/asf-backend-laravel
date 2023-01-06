<?php

namespace App\Containers\AppSection\Financial\UI\API\Transformers;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Financial\Enums\FinancialDocumentsStatus;
use App\Containers\AppSection\Financial\Models\FinancialDocument;
use App\Ship\Parents\Transformers\Transformer;

class FinancialDocumentTransformer extends Transformer
{
    use HashIdTrait;
    /**
     * @var  array
     */
    protected $defaultIncludes = [

    ];

    /**
     * @var  array
     */
    protected $availableIncludes = [

    ];

    public function transform(FinancialDocument $document): array
    {
        $response = [
            'id' => $document->getHashedKey(),
            'user_id' => $this->encode($document->user_id),
            'label' => $document->label,
            'name' => $document->init_file_name,
            'upload_date' => $document->created_at->format('Y-m-d'),
            'upload_id' => $this->encode($document->upload_id),
            'status' => $document->status,
            'status_label' => FinancialDocumentsStatus::getDescription($document->status),
            'url' => downloadUrl($document->uuid)
        ];

        return $response = $this->ifAdmin([
            'real_id'    => $document->id,
        ], $response);
    }
}
