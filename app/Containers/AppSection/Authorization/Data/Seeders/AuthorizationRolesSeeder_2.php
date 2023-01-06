<?php

namespace App\Containers\AppSection\Authorization\Data\Seeders;

use App\Containers\AppSection\Authorization\Enums\PermissionType;
use App\Containers\AppSection\Authorization\Tasks\CreateRoleTask;
use App\Ship\Parents\Seeders\Seeder;

class AuthorizationRolesSeeder_2 extends Seeder
{
    public function run(): void
    {
        // Default Roles ----------------------------------------------------------------
        app(CreateRoleTask::class)->run(PermissionType::ADMIN, 'Administrator', 'Administrator Role', 999);

        // borrower
        app(CreateRoleTask::class)->run(PermissionType::BORROWER, 'Borrower', 'Borrower Role', 999);
        // lender
        app(CreateRoleTask::class)->run(PermissionType::LENDER, 'Lender', 'Lender Role', 999);
    }
}
