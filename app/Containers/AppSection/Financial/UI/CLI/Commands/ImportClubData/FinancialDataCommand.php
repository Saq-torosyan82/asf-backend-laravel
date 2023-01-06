<?php
namespace App\Containers\AppSection\Financial\UI\CLI\Commands\ImportClubData;

use App\Ship\Parents\Commands\ConsoleCommand;
use App\Containers\AppSection\Financial\Actions\ImportClubData\FinancialDataAction;

class FinancialDataCommand extends ConsoleCommand
{
    protected $signature = 'financial:import_financials {folder_to_import}';
    protected $description = 'Import club financial information';

    public function handle() {
        echo "\nRunning FinancialDataCommand";
        printf(" ... for folder: [%s]", $this->argument('folder_to_import'));
        // helpers\hello();
        // $file_path = $this->argument('file_path');
        // $sport_id = $this->argument('sport_id');

    $summary_import = app(FinancialDataAction::class)->run($this->argument('folder_to_import'));

        // if(!$summary_import['status']) {
        //     echo 'Failed! ' . $summary_import['error_message'] . "\n";
        // } else {
        //     echo "Success!\n";
        // }

        // echo 'League inserted: ' . $summary_import['league_inserted'] . ' | League found: ' . $summary_import['league_found'] . "\n";
        // echo 'Club inserted: ' . $summary_import['club_inserted'] . ' | Club found: ' . $summary_import['club_found'] . "\n";
    }
}
