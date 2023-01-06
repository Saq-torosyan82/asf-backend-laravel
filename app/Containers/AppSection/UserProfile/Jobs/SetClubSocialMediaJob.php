<?php

namespace App\Containers\AppSection\UserProfile\Jobs;

use App\Containers\AppSection\UserProfile\Actions\SetSocialMediaLinksAction;
use App\Ship\Parents\Jobs\Job;

 class SetClubSocialMediaJob extends Job
 {
     private $clubs;

     public function __construct(array $clubs)
     {
         $this->clubs = $clubs;
     }

     public function handle()
     {
         foreach ($this->clubs as $club) {
             app(SetSocialMediaLinksAction::class)->run($club->id);
         }
     }
 }
