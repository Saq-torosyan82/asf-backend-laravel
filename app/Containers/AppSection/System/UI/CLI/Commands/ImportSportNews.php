<?php

namespace App\Containers\AppSection\System\UI\CLI\Commands;

use App\Containers\AppSection\System\Actions\ImportSportNewsAction;
use App\Containers\AppSection\System\Tasks\GetAllSportsTask;
use App\Ship\Parents\Commands\ConsoleCommand;

class ImportSportNews extends ConsoleCommand
{
    protected $signature = 'import-sport-news';
    protected $description = 'Import Sport News in Database!';

    /**
     * @return void
     */
    public function handle() {
        try {
            $sports = app(GetAllSportsTask::class)->run()->toArray();

            if (!empty($sports)) {
                app(ImportSportNewsAction::class)->run($sports);
            }
            \Log::info('Import sport news success');
        } catch (\Exception $e){
            \Log::error('Error importing sport news: ' . $e->getMessage());
        }
    }

}
