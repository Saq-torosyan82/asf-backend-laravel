<?php

namespace App\Containers\AppSection\Communication\Tasks;

use App\Containers\AppSection\Communication\Data\Repositories\MessageRepository;
use App\Containers\AppSection\Communication\Enums\MessageStatus;
use App\Containers\AppSection\Upload\Tasks\FindUploadByIdTask;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileFieldTask;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetMessagesTask extends Task
{
    protected MessageRepository $repository;

    public function __construct(MessageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($comId, $loggedInUserId)
    {
        try {
            $unread_messages = $this->repository->select('id')
                ->where('is_read', MessageStatus::UNREAD)
                ->where('communication_id', $comId)
                ->where('sender', '<>', $loggedInUserId)
                ->get();

            if (!empty($unread_messages)) {
                foreach ($unread_messages as $unread_message) {
                    app(UpdateMessageTask::class)->run($unread_message->id, ['is_read' => MessageStatus::READ]);
                }
            }

            $messages = $this->repository
                ->select(
                    'communication_messages.id',
                    'communication_messages.sender',
                    'communication_messages.message_body',
                    'communication_messages.created_at as sent_date',
                    'communication_messages.is_read'
                )
                ->addSelect(\DB::raw("GROUP_CONCAT(DISTINCT `ca`.`upload_id`) as upload_ids"))
                ->addSelect(\DB::raw("GROUP_CONCAT(DISTINCT `cp`.`user_id`) as recievers"))
                ->addSelect(\DB::raw("IF(communication_messages.sender = $loggedInUserId, 1, 0) AS send")) // if 1 the message was sent by logged in user otherwise logged in user is reciever
                ->leftjoin('communication_participants as cp','cp.communication_id', '=', 'communication_messages.communication_id')
                ->leftjoin('communication_attachements as ca','ca.message_id','=','communication_messages.id')
                ->where('communication_messages.communication_id', $comId)
                ->whereColumn('cp.user_id', '<>', 'communication_messages.sender')
                ->groupBy('communication_messages.id')->get();

            return $messages;
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
