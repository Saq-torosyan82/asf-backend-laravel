<?php

namespace App\Containers\AppSection\Communication\Tasks;

use App\Containers\AppSection\Communication\Data\Repositories\ParticipantRepository;
use App\Containers\AppSection\Upload\Tasks\DownloadAvatarTask;
use App\Containers\AppSection\Upload\Tasks\FindUploadByIdTask;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Containers\AppSection\UserProfile\Tasks\FindUserProfileFieldTask;
use App\Ship\Parents\Tasks\Task;
use File;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class GetParticipantsInfoTask extends Task
{
    protected ParticipantRepository $repository;

    public function __construct(ParticipantRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id): array
    {
        $participantIds = $this->repository->select('user_id')
            ->where('communication_id', $id)
            ->get();

        $result = [];
        foreach ($participantIds as $participantId) {
            $userData = app(FindUserByIdTask::class)->run($participantId->user_id);

            if (!empty($userData)) {
                $avatarData = app(FindUserProfileFieldTask::class)->run($participantId->user_id, Group::USER, Key::AVATAR);

                $avatar = '';
                if (!empty($avatarData) && $avatarData != null) {
                    $avatarValue = app(FindUploadByIdTask::class)->run($avatarData->value);
                    if (Storage::exists($avatarValue->file_path)) {
                        $avatar = new JsonResponse(
                            base64_encode(File::get(Storage::path($avatarValue->file_path)))
                        );
                    }
                }

                array_push($result, [
                    'user_id' => $participantId->user_id,
                    'is_admin' => $userData->is_admin,
                    'full_name' => trim($userData->first_name . ' ' . $userData->last_name),
                    'avatar' => $avatar,
                ]);
            }
        }

        return $result;
    }
}
