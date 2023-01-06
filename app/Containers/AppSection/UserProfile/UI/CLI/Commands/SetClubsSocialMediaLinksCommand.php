<?php

namespace App\Containers\AppSection\UserProfile\UI\CLI\Commands;

use App\Containers\AppSection\UserProfile\Jobs\SetClubSocialMediaJob;
use App\Containers\AppSection\UserSponsorship\Actions\GetAllClubsAction;
use App\Ship\Parents\Commands\ConsoleCommand;

class SetClubsSocialMediaLinksCommand extends ConsoleCommand
{
    protected $signature = "set-club-social-media-links";

    protected $description = "Setting social media links for clubs";

    public function handle(): void
    {
        $clubs = app(GetAllClubsAction::class)->run();
        SetClubSocialMediaJob::dispatch($clubs);
    }
}
