<?php

namespace App\Containers\AppSection\Upload\UI\API\Transformers;

use App\Containers\AppSection\Upload\Models\UserDocument;
use App\Ship\Parents\Transformers\Transformer;

class UserDocumentTransformer extends Transformer
{
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

    public function transform(UserDocument $userdocument): array
    {
        $response = [
            'object' => $userdocument->getResourceKey(),
            'type' => $userdocument->type,
            'id' => $userdocument->uuid,
            'url' => $userdocument->Upload->file_path,
        ];

        return $response = $this->ifAdmin([
            'real_id'    => $userdocument->id,
            // 'deleted_at' => $userdocument->deleted_at,
        ], $response);
    }
}
