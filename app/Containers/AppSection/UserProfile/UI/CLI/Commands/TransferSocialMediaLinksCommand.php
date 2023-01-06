<?php


namespace App\Containers\AppSection\UserProfile\UI\CLI\Commands;


use App\Containers\AppSection\UserProfile\Actions\UpdateSocialMediaFollowersAction;
use App\Containers\AppSection\UserProfile\Actions\TransferSocialMediaLinksAction;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Commands\ConsoleCommand;

class TransferSocialMediaLinksCommand extends ConsoleCommand
{
    protected $signature = "social-media-followers {action :  action(update, transfer)}";

    protected $description = "Transfer social media links from user_profiles table in social_media_followers table and Update social media for users";

    const ACTION_UPDATE = 'update';
    const ACTION_TRANSFER = 'transfer';

    /**
     * @throws CreateResourceFailedException
     */
    public function handle(): void
    {

        $action = $this->argument('action');

        if ($action === self::ACTION_UPDATE) {
            app(UpdateSocialMediaFollowersAction::class)->run();
            $this->info('Check social media followers finished');
        } else if ($action === self::ACTION_TRANSFER) {
            app(TransferSocialMediaLinksAction::class)->run();
            $this->info('Update social media followers table finished');
        } else {
            $this->error('invalid action');
        }
    }
}
