<?php

namespace App\Containers\AppSection\Upload\UI\API\Transformers;

use App\Containers\AppSection\Upload\Models\Upload;
use App\Ship\Parents\Transformers\Transformer;

class UploadTransformer extends Transformer
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

    public function transform(Upload $upload): array
    {
        $response = [
            'object' => $upload->getResourceKey(),
            'id' => $upload->getHashedKey(),
            'privacy' => $upload->privacy,
            'upload_type' => $upload->upload_type,
            'user_id' => $upload->user_id,
            'uploaded_by' => $upload->uploaded_by,
            'init_file_name' => $upload->init_file_name,
            'file_mime' => $upload->file_mime,
            'file_size' => $upload->file_size,
            'file_name' => $upload->file_name,
            'file_path' => $upload->file_path
        ];

        return $response = $this->ifAdmin([
            'real_id'    => $upload->id,
            // 'deleted_at' => $upload->deleted_at,
        ], $response);
    }
}
