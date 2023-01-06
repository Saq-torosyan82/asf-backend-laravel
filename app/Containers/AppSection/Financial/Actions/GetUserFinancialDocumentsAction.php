<?php

namespace App\Containers\AppSection\Financial\Actions;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Financial\Enums\FinancialDocumentsStatus;
use App\Containers\AppSection\Financial\Tasks\GetUserFinancialDocumentsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;

class GetUserFinancialDocumentsAction extends Action
{
    use HashIdTrait;
    public function run(Request $request)
    {
        $user = Auth::user();
        $data = [];
        $documents = app(GetUserFinancialDocumentsTask::class)
            ->run($user->isCorporate() ? $user->id : null, $user->isAdmin() ? $request->club_id : null, );
        if ($documents) {
            foreach ($documents as $document) {
                if (!isset($data[$document['label']])) {
                    $data[$document->label] = [
                        'label' => $document->label,
                        'items' => []
                    ];
                }
                $data[$document['label']]['items'][] = [
                    'id' => $this->encode($document['id']),
                    'user_id' => $this->encode($document['user_id']),
                    'name' => $document['init_file_name'],
                    'upload_date' => $document['created_at']->format('Y-m-d'),
                    'upload_id' => $this->encode($document['upload_id']),
                    'status' => $document['status'],
                    'status_label' => FinancialDocumentsStatus::getDescription($document['status']),
                    'url' => downloadUrl($document['uuid'])
                ];
            }
        }
        return $data;
    }
}
