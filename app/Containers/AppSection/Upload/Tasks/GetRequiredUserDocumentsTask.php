<?php

namespace App\Containers\AppSection\Upload\Tasks;

use App\Containers\AppSection\Upload\Enums\UserDocumetType;
use App\Ship\Parents\Tasks\Task;

class GetRequiredUserDocumentsTask extends Task
{
    public function run(string $contract_type)
    {
        $all_documents = UserDocumetType::getRequiredDealDocuments($contract_type);

        $data = [];
        foreach ($all_documents as $type) {
            $data[$type] = 1;
        }

        return $data;
    }
}
