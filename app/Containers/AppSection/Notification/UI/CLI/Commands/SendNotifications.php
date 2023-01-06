<?php

namespace App\Containers\AppSection\Notification\UI\CLI\Commands;

use App\Containers\AppSection\Notification\Actions\SendDealIsNotFinishedFirstNotificationAction;
use App\Containers\AppSection\Notification\Actions\SendDealIsNotFinishedSecondNotificationAction;
use App\Containers\AppSection\Notification\Actions\SendOnboardingIsNotFinishedFirstNotificationAction;
use App\Containers\AppSection\Notification\Actions\SendOnboardingIsNotFinishedSecondNotificationAction;
use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Ship\Parents\Commands\ConsoleCommand;

class SendNotifications extends ConsoleCommand
{
    protected $signature = "send-notifications";

    protected $description = "Send notifications to the users";

    public function handle()
    {
        // SEEMEk: add error logging

        // send first borrower onboarding reminder
        app(SendOnboardingIsNotFinishedFirstNotificationAction::class)->run();

        // send second borrower onboarding reminder
        app(SendOnboardingIsNotFinishedSecondNotificationAction::class)->run();

        // send first deal not finished reminder
        app(SendDealIsNotFinishedFirstNotificationAction::class)->run();

        // send second deal not finished reminder
        app(SendDealIsNotFinishedSecondNotificationAction::class)->run();
    }

}
