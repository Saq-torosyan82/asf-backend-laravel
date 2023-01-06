<?php

namespace App\Containers\AppSection\UserProfile\Actions;

use App\Containers\AppSection\UserProfile\Tasks\FindCompanyByCompanyRegistrationNumberTask;
use App\Ship\Parents\Actions\Action;

class GetUserParentIdSubAction extends Action
{
    public function run($companyRegistrationNumber)
    {
        $parentId = null;
        $sameCompanies = app(FindCompanyByCompanyRegistrationNumberTask::class)->run($companyRegistrationNumber);
        // Get the admin id , if user parent_id is null this means this user is admin
        foreach ($sameCompanies as $company) {
            if($company->user && $company->user->parent_id === null) {
                $parentId = $company->user->id;
                break;
            }
        }

        return $parentId;
    }
}
