<?php

namespace App\Containers\AppSection\UserSponsorship\UI\CLI\Commands;

use App\Containers\AppSection\UserSponsorship\Actions\ImportClubSponsorsAction;
use App\Containers\AppSection\UserSponsorship\Tasks\GetAllClubSponsorsTask;
use App\Ship\Parents\Commands\ConsoleCommand;

class ImportClubSponsorsCommand extends ConsoleCommand
{
    protected $signature = "import-club-sponsors";

    protected $description = "Import club sponsors from fact_data";

    public function handle(): void {

        app(ImportClubSponsorsAction::class)->run();

        // Show which logos was transferred
        $sponsors = app(GetAllClubSponsorsTask::class)->run();
        foreach ($sponsors as $sponsor) {
            if($sponsor && $sponsor->logo)  $this->info('Logo for '.$sponsor->name.' is '.$sponsor->logo);
        }
    }

}
