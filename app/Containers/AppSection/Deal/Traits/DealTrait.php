<?php

namespace App\Containers\AppSection\Deal\Traits;

use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\Deal\Tasks\FindDealByIdTask;

trait DealTrait
{

    public function isUserDeal() {
        $deal = app(FindDealByIdTask::class)->run($this->id);
        return $deal->user_id == $this->user()->id;
    }

    public function isParentUserDeal() {
        $deal = app(FindDealByIdTask::class)->run($this->id);
        $user = app(FindUserByIdTask::class)->run($deal->user_id);
        return $user->parent_id == $this->user()->id;
    }

}