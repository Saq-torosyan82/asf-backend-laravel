<?php
namespace App\Containers\AppSection\Financial\UI\CLI\Commands\ImportClubData;

use App\Ship\Parents\Commands\ConsoleCommand;
use App\Containers\AppSection\Financial\Actions\ImportClubData\FinancialDataNewAction;

class FinancialDataNewCommand extends ConsoleCommand
{
    protected $signature = 'financial:import_financials_new {folder_to_import}';
    protected $description = 'New version of import club financial information';

    public function handle() {
        echo "\nRunning FinancialDataNewCommand";
        printf(" ... for folder: [%s]", $this->argument('folder_to_import'));
        app(FinancialDataNewAction::class)->run($this->argument('folder_to_import'));
        echo "\nImport finished\n";
    }
}
