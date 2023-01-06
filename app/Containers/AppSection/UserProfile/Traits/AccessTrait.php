<?php

namespace App\Containers\AppSection\UserProfile\Traits;

use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\UserProfile\Tasks\GetBorrowerTypeTask;
use App\Ship\Exceptions\NotAuthorizedResourceException;
use App\Containers\AppSection\System\Enums\BorrowerType;

trait AccessTrait
{
    use BorrowerTrait;

    public function isAthleteAgentOrAdmin()
    {
        $user = \Auth::user();
        if ($user->isAdmin()) {
            return true;
        }

        return $this->isAthleteAgent();
    }

    public function isAthletAgentAgencyOrAdmin()
    {
        $user = \Auth::user();
        if ($user->isAdmin()) {
            return true;
        }

        return ($this->isAthleteAgent() || $this->isAthletAgentAgency()) ? true : false;
    }

    public function isAthletAgentAgency()
    {
        if (!$this->isAgent()) {
            return false;
        }

        $user = $this->getRealUser();

        if (is_null($user)) {
            return false;
        }

        // get user parent id
        if (!$user->parent_id) {
            return false;
        }

        $parent_id = $user->parent_id;

        // get data about Agent
        $agent = app(FindUserByIdTask::class)->run($parent_id);
        if (is_null($agent)) {
            return false;
        }

        // maybe we should check the user permissions
        if ($agent->parent_id == $this->user()->id) {
            return true;
        }

        return false;
    }


    public function isAdmin()
    {
        $user = \Auth::user();
        return $user->isAdmin();
    }

    public function isAgency()
    {
        $user = \Auth::user();
        return $user->isAgency();
    }
    public function isLender()
    {
        $user = \Auth::user();
        return $user->isLender() ? true : false;
    }

}
