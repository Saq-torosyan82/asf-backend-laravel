<?php

namespace App\Containers\AppSection\UserSponsorship\UI\CLI\Commands;

use App\Containers\AppSection\UserSponsorship\Actions\GetAllClubsAction;
use App\Containers\AppSection\UserSponsorship\Jobs\SetClubSponsorsJob;
use App\Ship\Parents\Commands\ConsoleCommand;

class SetClubSposorsCommand extends ConsoleCommand
{
    protected $signature = "set-club-sponsors";

    protected $description = "Setting club sponsors";

    public function handle(): void {
        $clubs = app(GetAllClubsAction::class)->run();
        SetClubSponsorsJob::dispatch($clubs);
    }
}
