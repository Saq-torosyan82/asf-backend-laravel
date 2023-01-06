<?php

namespace App\Containers\AppSection\UserProfile\Traits;

use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\UserProfile\Tasks\GetBorrowerTypeTask;
use App\Ship\Exceptions\NotAuthorizedResourceException;
use App\Containers\AppSection\System\Enums\BorrowerType;

trait BorrowerTrait
{
    public function isNotBorrower(): bool
    {
        $borrowerType = app(GetBorrowerTypeTask::class)->run($this->user()->id);
        if ($borrowerType) {
            throw new NotAuthorizedResourceException("User already completed onboarding");
        }

        return $borrowerType == null;
    }

    public function isBorrower(): bool
    {
        $borrowerType = app(GetBorrowerTypeTask::class)->run($this->user()->id);
        return $borrowerType != null;
    }

    public function isAgent(): bool
    {
        $borrowerType = app(GetBorrowerTypeTask::class)->run($this->user()->id);
        if ($borrowerType == null) {
            return false;
        }

        return $borrowerType == BorrowerType::AGENT;
    }

    public function isAthlete(): bool
    {
        $borrowerType = app(GetBorrowerTypeTask::class)->run($this->user()->id);
        if ($borrowerType == null) {
            return false;
        }

        return $borrowerType == BorrowerType::ATHLETE;
    }

    public function isCorporate(): bool
    {
        $borrowerType = app(GetBorrowerTypeTask::class)->run($this->user()->id);
        if ($borrowerType == null) {
            return false;
        }

        return $borrowerType == BorrowerType::CORPORATE;
    }

    public function isAthleteAgent()
    {
        if (!$this->isAgent()) {
            return false;
        }

        $user = $this->getRealUser();
        if (is_null($user)) {
            return false;
        }

        // maybe we should check the user permissions

        if ($user->parent_id == $this->user()->id) {
            return true;
        }

        return false;
    }

    protected function getRealUser()
    {
        $user_id_keys = [
            'user_id' => 1,
            'userId' => 1,
            'id' => 1,
        ];

        $all = $this->all();

        $user_id = '';
        foreach ($user_id_keys as $key => $unit) {
            if (!isset($all[$key]) || !$all[$key]) {
                continue;
            }

            $user_id = $all[$key];
            break;
        }

        if (!$user_id) {
            return null;
        }

        // get data about user id
        return app(FindUserByIdTask::class)->run($user_id);
    }

    public function isOnboardingComplete(): bool
    {
        $borrowerType = app(GetBorrowerTypeTask::class)->run(Auth::id());

        if ($borrowerType != null) {
            throw new NotAuthorizedResourceException("User already completed onboarding");
        }

        return $borrowerType == null;
    }
}
