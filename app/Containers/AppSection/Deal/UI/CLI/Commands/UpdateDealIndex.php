<?php

namespace App\Containers\AppSection\Deal\UI\CLI\Commands;

use App\Containers\AppSection\Deal\Actions\SetDealIndexFieldsAction;
use App\Containers\AppSection\Deal\Tasks\GetAllDealsTask;
use App\Ship\Parents\Commands\ConsoleCommand;
use App\Ship\Parents\Exceptions\Exception;

class UpdateDealIndex extends ConsoleCommand
{
    protected $signature = 'update-deal-index';
    protected $description = 'Update index fields for deals';

    public function handle()
    {
        $deals = app(GetAllDealsTask::class)->run();
        foreach ($deals as $deal) {
            try {
                app(SetDealIndexFieldsAction::class)->run($deal);
            } catch (Exception $e) {
                Log::error(sprintf('[deal_id:%s] error update deal index: %s', $deal->id, $e->getMessage()));
                continue;
            }
        }
    }
}
