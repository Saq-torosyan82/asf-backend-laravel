<?php

namespace App\Containers\AppSection\Notification\Tasks;

use App\Ship\Parents\Tasks\Task;

class LogNotificationTask extends Task
{
    /**
     * @throws \App\Ship\Exceptions\CreateResourceFailedException
     */
    public function run($type, $entity_id, $entity_type, $subject, $email, $data, $receiver): void
    {
        $notificationContent = view('appSection@notification::' . $receiver . '.' . $type, $data['vars'])->render();

        app(CreateNotificationLogTask::class)->run([
            'type' => $type,
            'entity_id' => $entity_id,
            'entity_type' => $entity_type,
            'subject' => $subject,
            'to' => $email,
            'content' => $notificationContent,
            'data' => json_encode($data)
        ]);
    }
}
