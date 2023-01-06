<?php

namespace App\Containers\AppSection\System\UI\CLI\Commands;
use App\Containers\AppSection\System\Actions\ImportSportClubsAction;
use App\Ship\Parents\Commands\ConsoleCommand;

class ImportSportClubs extends ConsoleCommand
{
    protected $signature = 'import-sport-clubs {sport_id} {file_path}';
    protected $description = 'Import Sport Clubs in DataBase!';

    public function handle() {
        $file_path = $this->argument('file_path');
        $sport_id = $this->argument('sport_id');

        $summary_import = app(ImportSportClubsAction::class)->run($sport_id, $file_path);

        if(!$summary_import['status']) {
            echo 'Failed! ' . $summary_import['error_message'] . "\n";
        } else {
            echo "Success!\n";
        }

        echo 'League inserted: ' . $summary_import['league_inserted'] . ' | League found: ' . $summary_import['league_found'] . "\n";
        echo 'Club inserted: ' . $summary_import['club_inserted'] . ' | Club found: ' . $summary_import['club_found'] . "\n";
    }
}