<?php

namespace App\Containers\AppSection\UserSponsorship\Jobs;

use App\Containers\AppSection\UserSponsorship\Actions\SetClubSponsorsAction;
use App\Containers\AppSection\UserSponsorship\Tasks\GetAllUserSponsorshipsTask;
use App\Ship\Parents\Jobs\Job;
use Illuminate\Foundation\Bus\Dispatchable;

class SetClubSponsorsJob extends Job
 {
     use Dispatchable;

     private $clubs;

     public function __construct(array $clubs)
     {
         $this->clubs = $clubs;
     }

     public function handle(): void
     {
         foreach ($this->clubs as $club) {
             $sponsors = app(GetAllUserSponsorshipsTask::class)->run($club->user_id);
             if($sponsors->count() <= 0) {
              app(SetClubSponsorsAction::class)->run($club->user_id);
             }
         }
     }
 }
