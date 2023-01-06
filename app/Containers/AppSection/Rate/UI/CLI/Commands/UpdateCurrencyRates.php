<?php

namespace App\Containers\AppSection\Rate\UI\CLI\Commands;
use App\Containers\AppSection\Rate\Actions\UpdateRateByCurrencyAction;
use App\Ship\Parents\Commands\ConsoleCommand;
use Log;

class UpdateCurrencyRates extends ConsoleCommand
{
    protected $signature = 'update-currency-rates';
    protected $description = 'Update Currency Rates in DataBase!';

    /**
     * @return void
     */
    public function handle() {
        try {
            app(UpdateRateByCurrencyAction::class)->run();
            Log::info('Getting currency rates success');
        } catch (\Exception $e) {
            Log::error('Error getting currency rates: ' . $e->getMessage());
        }
    }
}
