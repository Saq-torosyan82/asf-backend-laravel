<?php

namespace App\Containers\AppSection\Communication\UI\API\Transformers;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Communication\Models\Communication;
use App\Containers\AppSection\Deal\UI\API\Transformers\DealTransformer;
use App\Ship\Parents\Transformers\Transformer;

use App\Containers\AppSection\Communication\Enums\{
    CommunicationType,
    QuestionType
};

class CommunicationTransformer extends Transformer
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

    public function transform(Communication $communication): array
    {
        $dealTransformer = new DealTransformer();

        $response = [
            'id' => $communication->getHashedKey(),
            'title' => $communication->title,
            'type' => $communication->type,
            'type_label' => CommunicationType::getText($communication->type),
            'question_type' => QuestionType::getText($communication->question_type),
            'created_at' => gmdate('d.m.Y h:i A', strtotime($communication->created_at)) . ' (GMT)',
            'participants' => $communication->participants,
            'deal' => !empty($communication->deal) ? $dealTransformer->transform($communication->deal) : [],
            'last_activity' => gmdate('d.m.Y h:i A', strtotime($communication->last_activity)) . ' (GMT)'
        ];

        if (!empty($response['deal'])) {
            $response['deal']['start_year'] = date('Y', strtotime($response['deal']['start_date']));
            $response['deal']['end_year'] = date('Y', strtotime($response['deal']['finish_date']));
        }

        return $this->ifAdmin([
            'real_id'    => $communication->id,
        ], $response);
    }
}
