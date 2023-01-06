<?php

namespace App\Containers\AppSection\Deal\Actions;

use App\Containers\AppSection\Deal\Enums\OfferStatus;
use App\Containers\AppSection\Deal\Exceptions\ConflictOfferStatusException;
use App\Containers\AppSection\Deal\Exceptions\InvalidDealOfferException;
use App\Containers\AppSection\Deal\Exceptions\MissingRejectOfferReasonException;
use App\Containers\AppSection\Deal\Models\DealOffer;
use App\Containers\AppSection\Deal\Tasks\FindOfferByIdTask;
use App\Containers\AppSection\Deal\Tasks\UpdateDealOfferTask;
use App\Containers\AppSection\Deal\Tasks\UpdateDealTask;
use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Containers\AppSection\Deal\Tasks\FindDealByIdTask;
use App\Containers\AppSection\Notification\Enums\MailContext;
use App\Containers\AppSection\Notification\Tasks\NotificationTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Requests\Request;

class UpdateDealOfferAction extends Action
{
    public function run(Request $request): DealOffer
    {
        // SEEMEk: check for permissions


        $data = $request->sanitizeInput(
            [
                'status',
                'reason',
            ]
        );

        // get offer
        $offer = app(FindOfferByIdTask::class)->run($request->offer_id);
        if ($offer->deal_id != $request->id) {
            throw new InvalidDealOfferException();
        }

        $offerData = [];
        if ($data['status'] == self::REJECTED()) {
            // check for reason param
            if (!isset($data['reason']) || !$data['reason']) {
                throw new MissingRejectOfferReasonException();
            }

            // check for current statsus
            if ($offer->status == OfferStatus::REJECTED) {
                throw new ConflictOfferStatusException('offer already rejected');
            }

            $offerData['status'] = OfferStatus::REJECTED;
            $offerData['reject_reason'] = $data['reason'];

            try {
                $res = app(UpdateDealOfferTask::class)->run($request->offer_id, $offerData);
            } catch (\Exception $e) {
                throw $e;
            }

            // send notification
            try {
                $data = [
                    // maybe add more data
                    'vars' => [
                        'linkToDeal' => config('appSection-authentication.login_token_redirect') . '/deals?id='.$offer->deal->getHashedKey(),
                        'dealType' => $offer->deal->deal_type,
                        'lenderName' => $offer->user->first_name . ' ' . $offer->user->last_name,
                        'email' => $offer->deal->user->email,
                        'first_name' => $offer->deal->user->first_name,
                        'last_name' => $offer->deal->user->last_name,
                    ],
                    'lenders_ids' => [$offer->offer_by],
                    'entity_id' => $request->offer_id
                ];

                app(NotificationTask::class)->run($offer->deal, MailContext::BORROWER_REJECTS_TERM_SHEET, $data);
            } catch (\Exception $e) {
                // silently ignore
            }

            return $res;

        }

        if ($data['status'] == self::ACCEPTED()) {
            // check for current statsus
            if ($offer->status == OfferStatus::ACCEPTED) {
                throw new ConflictOfferStatusException('offer already accepted');
            }

            // check if there is another accepted offer
            $deal = app(FindDealByIdTask::class)->run($request->id);

            foreach ($deal->offers as $row) {
                if ($row->status == OfferStatus::ACCEPTED) {
                    throw new ConflictOfferStatusException('another offer was accepted before');
                }
            }

            $offerData['status'] = OfferStatus::ACCEPTED;
            try {
                $offer = app(UpdateDealOfferTask::class)->run($request->offer_id, $offerData);
            } catch (\Exception $e) {
                throw $e;
            }

            // send notification
            try {
                $data = [
                    // maybe add more data
                    'vars' => [
                        'linkToDeal' => config('appSection-authentication.login_token_redirect') . '/deals?id='.$offer->deal->getHashedKey(),
                        'dealType' => $offer->deal->deal_type,
                        'lenderName' => $offer->user->first_name . ' ' . $offer->user->last_name,
                        'email' => $offer->deal->user->email,
                        'first_name' => $offer->deal->user->first_name,
                        'last_name' => $offer->deal->user->last_name,
                    ],
                    'lenders_ids' => [$offer->offer_by],
                    'entity_id' => $request->offer_id
                ];

                app(NotificationTask::class)->run($offer->deal, MailContext::BORROWER_ACCEPTS_TERM_SHEET, $data);
            } catch (\Exception $e) {
                // silently ignore
            }


            // reject the rest of the offers
            foreach ($deal->offers as $row) {
                if ($row->status == OfferStatus::REJECTED || $row->id == $request->offer_id) {
                    continue;
                }

                try {
                    app(UpdateDealOfferTask::class)->run(
                        $row->id,
                        [
                            'status' => OfferStatus::REJECTED,
                            'reject_reason' => $this->getDefaultRejectReason()
                        ]
                    );

                    // send notification
                    $data = [
                        // maybe add more data
                        'vars' => [
                            'linkToDeal' => config('appSection-authentication.login_token_redirect') . '/deals?id='.$row->deal->getHashedKey(),
                            'dealType' => $row->deal->deal_type,
                            'lenderName' => $row->deal->offers->first()->user->first_name . ' ' . $row->deal->offers->first()->user->last_name,
                            'email' => $row->deal->user->email,
                            'first_name' => $row->deal->user->first_name,
                            'last_name' => $row->deal->user->last_name,

                        ],
                        'lenders_ids' => [$row->offer_by],
                        'entity_id' => $row->id
                    ];

                    app(NotificationTask::class)->run($offer->deal, MailContext::BORROWER_REJECTS_TERM_SHEET, $data);
                } catch (\Exception $e) {
                    // silently ignore
                }

            }// foreach

            // update deal reason
            $data = [
                'reason' => StatusReason::ACCEPTED_BORROWER,
                'status' => DealStatus::ACCEPTED,
            ];
            app(UpdateDealTask::class)->run($request->id, $data);


            return $offer;
        }
    }

    private static function REJECTED()
    {
        return "rejected";
    }

    private static function ACCEPTED()
    {
        return 'accepted';
    }

    private function getDefaultRejectReason()
    {
        return 'Another offer was accepted';
    }
}
