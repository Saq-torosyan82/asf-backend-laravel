<?php

namespace App\Containers\AppSection\Communication\UI\API\Transformers;

use App\Containers\AppSection\Communication\Models\Message;
use App\Containers\AppSection\Upload\Tasks\FindUploadByIdTask;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileFieldTask;
use App\Ship\Parents\Transformers\Transformer;
use Carbon\Carbon;
use File;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessagesTransformer extends Transformer
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

    public function transform(Message $message): array
    {
        $sent_date = $message->sent_date ? : Carbon::now();
        $response = [
            'id' => $message->getHashedKey(),
            'message_body' => $message->message_body,
            'sent_date' => gmdate('d. M Y, h:i A', strtotime($sent_date)) . ' (GMT)',
            'last_activity' => gmdate('d.m.Y h:i A', strtotime($sent_date)) . ' (GMT)',
            'is_read' => $message->is_read,
            'recievers' => [],
            'attachements' => []
        ];

        $senderInfo = app(FindUserByIdTask::class)->run($message->sender);
        $senderAvatarData = app(FindUserProfileFieldTask::class)->run($message->sender, Group::USER, Key::AVATAR);

        $avatar = '';
        if (!empty($senderAvatarData) && $senderAvatarData != null) {
            $avatarValue = app(FindUploadByIdTask::class)->run($senderAvatarData->value);
            $avatar =  (!empty($avatarValue) && $avatarValue != null) && Storage::exists($avatarValue->file_path)  ? new JsonResponse(
                base64_encode(File::get(Storage::path($avatarValue->file_path)))
            ) : '';
        }
        $response['sender'] = [
            'id' => $message->sender,
            'full_name' => trim($senderInfo->first_name . ' ' . $senderInfo->last_name),
            'avatar' => $avatar
        ];

        if (!empty($message->recievers)) {
            $recievers = explode(',', $message->recievers);

            foreach ($recievers as $recieverId) {
                //get message reciever info
                $recieverInfo = app(FindUserByIdTask::class)->run($recieverId);
                $recieverAvatarData = app(FindUserProfileFieldTask::class)->run($recieverId, Group::USER, Key::AVATAR);

                $avatar = '';
                if (!empty($recieverAvatarData) && $recieverAvatarData != null) {
                    $avatarValue = app(FindUploadByIdTask::class)->run($recieverAvatarData->value);
                    $avatar = (!empty($avatarValue) && $avatarValue != null && Storage::exists($avatarValue->file_path))   ? new JsonResponse(
                        base64_encode(File::get(Storage::path($avatarValue->file_path)))
                    ) : '';
                }

                array_push($response['recievers'], [
                    'id' => $recieverId,
                    'full_name' => $recieverId == Auth::user()->id ? 'Me' : trim($recieverInfo->first_name . ' ' . $recieverInfo->last_name),
                    'avatar' => $avatar
                ]);
            }
        }

        if (!empty($message->upload_ids)) {
            $uploadIds = explode(',', $message->upload_ids);
            foreach ($uploadIds as $uploadId) {
                $attachement = app(FindUploadByIdTask::class)->run($uploadId);

                $response['attachements'][] = [
                    'id' => $attachement->id,
                    'uuid' => $attachement->uuid,
                    'init_file_name' => $attachement->init_file_name,
                    'file_path' => $attachement->file_path,
                    'download_url' => downloadUrl($attachement->uuid)
                ];

            }
        }

        return $this->ifAdmin([
            'real_id'    => $message->id,
        ], $response);
    }
}
