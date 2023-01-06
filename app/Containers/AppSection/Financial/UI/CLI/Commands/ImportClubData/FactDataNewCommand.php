<?php
namespace App\Containers\AppSection\Financial\UI\CLI\Commands\ImportClubData;

use App\Ship\Parents\Commands\ConsoleCommand;
use App\Containers\AppSection\Financial\Actions\ImportClubData\FactDataNewAction;

class FactDataNewCommand extends ConsoleCommand
{
    protected $signature = 'financial:import_facts_new {folder_to_import}';
    protected $description = 'Import club details';

    public function handle() {
        echo "\nRunning FactDataNewCommand";
        printf(" ... for folder: [%s]", $this->argument('folder_to_import'));
        app(FactDataNewAction::class)->run($this->argument('folder_to_import'));
        echo "\nImport finished";
    }
}
