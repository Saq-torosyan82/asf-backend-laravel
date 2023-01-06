<?php

namespace App\Containers\AppSection\Financial\Actions;


use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Financial\Enums\FinancialDocumentsStatus;
use App\Containers\AppSection\Financial\Tasks\UpdateDocumentsStatusTask;
use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Tasks\NotificationTask;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Actions\Action;

class UpdateDocumentsStatusAction extends Action
{
    use HashIdTrait;
    public function run(Request $request)
    {
        if (isset($request->ids)) {
            $status = FinancialDocumentsStatus::PENDING;
            if ($request->is_approved) {
                $status = FinancialDocumentsStatus::ACCEPTED;
                $mailContext = MailContext::ADMIN_APPROVED_FINANCIAL_DOCUMENTS;
            } elseif ($request->is_rejected) {
                $status = FinancialDocumentsStatus::REJECTED;
                $mailContext = MailContext::ADMIN_REJECTED_FINANCIAL_DOCUMENTS;
            }
            foreach ($request->ids as $id) {
                app(UpdateDocumentsStatusTask::class)->run($this->decode($id), [
                    'status' => $status,
                    'reason' => $request->reason
                ]);
            }
            // send notification
            $user = app(FindUserByIdTask::class)->run($request->user_id);
            $name = trim($user->first_name . ' ' . $user->last_name);
            if (!$name) {
                $name = $user->email;
            }
            $data = [
                'vars' => [
                    'name' => $name,
                    'sheet' => $request->sheet,
                    'reason' => $request->reason
                ],
                'allow_multiple' => true
            ];
            try {
                app(NotificationTask::class)->run($user, $mailContext, $data);
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            }

        }
    }
}
