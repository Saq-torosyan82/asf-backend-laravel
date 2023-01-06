<?php

namespace App\Containers\AppSection\Communication\Actions;

use App\Containers\AppSection\Communication\Enums\MessageStatus;
use App\Containers\AppSection\Communication\Models\Communication;
use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Tasks\NotificationTask;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\Communication\Tasks\{CreateMessageTask,
    CreateParticipantsTask,
    CreateTask,
    CreateAttachementTask,
    GetParticipantsInfoTask};
use App\Containers\AppSection\Communication\Enums\CommunicationType;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;
use App\Containers\AppSection\User\Tasks\GetAllUsersTask;

class CreateAction extends Action
{
    public function run(Request $request, $type = CommunicationType::DEALS):Communication
    {
        $user_id = Auth::user()->id;
        $participants = [$user_id];
        $communicationData = ['type' => $type];

        switch ($type) {
            case CommunicationType::SERVICE:
                $communicationData = array_merge($communicationData, [
                    'question_type' => $request->question_type,
                    'title' => $request->title,
                ]);

                $adminUsers = app(GetAllUsersTask::class)->admins()->ordered()->run()->toArray();
                $participants = array_unique(array_merge($participants, array_column($adminUsers['data'], 'id')));
                break;
            default:
                $communicationData = array_merge($communicationData, [
                    'title' => $request->title,
                    'deal_id' => $request->deal_id,
                ]);
                break;
        }

        if (isset($request->participant_id) && !in_array($request->participant_id, $participants)) {
            array_push($participants, $request->participant_id);
        }

        $communication = app(CreateTask::class)->run($communicationData);

        $message = app(CreateMessageTask::class)->run([
            'sender' => $user_id,
            'message_body' => $request->message_body ?? '',
            'communication_id' => $communication->id,
            'is_read' => MessageStatus::UNREAD
        ]);
        $communication['last_activity' ] = $message->created_at;

        $senderName = trim(Auth::user()->first_name . ' ' . Auth::user()->last_name);
        foreach($participants as $participant_id) {
            app(CreateParticipantsTask::class)->run([
                'communication_id' => $communication->id,
                'user_id' => $participant_id
            ]);

            if($participant_id != Auth::user()->id) {
                // send notification
                $receiver = app(FindUserByIdTask::class)->run($participant_id);
                $name = trim($receiver->first_name . ' ' . $receiver->last_name);
                if (!$name) {
                    $name = $receiver->email;
                }
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
        }
        $communication['participants'] = app(GetParticipantsInfoTask::class)->run($communication->id);

        if (isset($request->attachements)) {
            foreach ($request->attachements as $attachementId) {
                app(CreateAttachementTask::class)->run([
                    'message_id' => $message->id,
                    'upload_id' => $attachementId,
                ]);
            }
        }

        return $communication;
    }
}
