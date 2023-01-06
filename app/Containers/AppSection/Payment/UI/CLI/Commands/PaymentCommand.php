<?php

namespace App\Containers\AppSection\Payment\UI\CLI\Commands;

use App\Containers\AppSection\Payment\Actions\FillPaymentsAction;
use App\Containers\AppSection\Payment\Actions\SendFirstPaymentReminderAction;
use App\Containers\AppSection\Payment\Actions\SendPaymentConfirmationAction;
use App\Containers\AppSection\Payment\Actions\SendPaymentOverdueReminderAction;
use App\Containers\AppSection\Payment\Actions\SendSecondPaymentReminderAction;
use App\Ship\Parents\Commands\ConsoleCommand;
use Log;

class PaymentCommand extends ConsoleCommand
{
    protected $signature = "payments";

    protected $description = "fill payments table and send notifications";

    /**
     * @throws \App\Ship\Exceptions\CreateResourceFailedException
     */
    public function handle(): void
    {
        Log::info('start payments command');

        // fill payments data (only if data is missing)
        app(FillPaymentsAction::class)->run();

        app(SendPaymentOverdueReminderAction::class)->run();

        app(SendFirstPaymentReminderAction::class)->run();

        app(SendSecondPaymentReminderAction::class)->run();

        app(SendPaymentConfirmationAction::class)->run();

        Log::info('finished payments command');
    }

}
