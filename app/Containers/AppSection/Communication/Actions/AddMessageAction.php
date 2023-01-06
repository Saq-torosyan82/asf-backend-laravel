<?php

namespace App\Containers\AppSection\Communication\Actions;

use App\Containers\AppSection\Communication\Enums\MessageStatus;
use App\Containers\AppSection\Communication\Models\Message;
use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Tasks\NotificationTask;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\Communication\Tasks\{
    CreateMessageTask,
    CreateAttachementTask,
    FindByIdTask
};
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;

class AddMessageAction extends Action
{
    public function run(Request $request): Message
    {
        $message = app(CreateMessageTask::class)->run([
            'sender' => Auth::user()->id,
            'message_body' => $request->message_body ?? '',
            'communication_id' => $request->com_id,
            'is_read' => MessageStatus::UNREAD
        ]);

        $upload_ids = [];
        if (isset($request->attachements)) {
            foreach ($request->attachements as $attachementId) {
                app(CreateAttachementTask::class)->run([
                    'message_id' => $message->id,
                    'upload_id' => $attachementId,
                ]);

                $upload_ids[] = $attachementId;
            }
            $message->upload_ids = implode(',', $upload_ids);
        }

        //Get reciever id
        $communicationData = app(FindByIdTask::class)->run($request->com_id);
        $recievers = array_column(array_filter($communicationData->participants, function($participant) {
            return $participant['user_id'] != Auth::user()->id;
        }), 'user_id');
        $message->recievers = implode(',', $recievers);
        $senderName = (Auth::user()->first_name || Auth::user()->last_name) ? trim(Auth::user()->first_name . ' ' . Auth::user()->last_name) : "SportsFi";

        foreach($recievers as $id) {

            $receiver = app(FindUserByIdTask::class)->run($id);
            $name = trim($receiver->first_name . ' ' . $receiver->last_name);
            if (!$name) {
                $name = $receiver->email;
            }
            // send notification
            $data = [
                'vars' => [
                    'full_name' => $name,
                    'sender' => $senderName,
                ],
                'allow_multiple' => true
            ];
            try {
                app(NotificationTask::class)->run($receiver, MailContext::RECEIVE_MESSAGE, $data);
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            }
        }
        return $message;
    }
}
