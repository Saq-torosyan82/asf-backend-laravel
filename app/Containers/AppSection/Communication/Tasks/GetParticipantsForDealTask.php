<?php

namespace App\Containers\AppSection\Communication\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Communication\Data\Repositories\CommunicationRepository;
use App\Containers\AppSection\Deal\Enums\DealStatus;
use App\Containers\AppSection\Deal\Enums\OfferStatus;
use App\Containers\AppSection\Deal\Enums\StatusReason;
use App\Containers\AppSection\Deal\Tasks\FindDealByIdTask;
use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Tasks\Task;

class GetParticipantsForDealTask extends Task
{
    protected CommunicationRepository $repository;
    protected UserRepository $userRepository;

    public function __construct(CommunicationRepository $repository,
                                UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function run($deal_id, $user_id)
    {
        $participants = $this->userRepository->select('id','first_name','last_name', 'is_admin')
            ->where('id', '<>', $user_id)
            ->where('is_admin', 1)
            ->get();

        if ($deal_id) {
            $deal = app(FindDealByIdTask::class)->run($deal_id);
            if ($user_id !=  $deal->user_id) {
                $borrower = app(FindUserByIdTask::class)->run($deal->user_id);
                if (!empty($borrower)) {
                    $participants[] = $borrower;
                }
            }
            if ($deal->status == DealStatus::LIVE && $deal->reason == StatusReason::TERMS_UPLOADED) {
                $lender = $this->userRepository->select('users.id', 'users.first_name', 'users.last_name', 'users.is_admin')
                    ->join('deal_offers','users.id','=','deal_offers.offer_by')
                    ->where('deal_offers.status', '<>', OfferStatus::REJECTED)
                    ->where('deal_offers.deal_id', $deal_id)
                    ->where('deal_offers.offer_by','<>',$user_id)
                    ->first();
                if (!empty($lender)) {
                    $participants[] = $lender;
                }
            }
        }


        $data = [];
        foreach($participants as $participant) {
            $data[] = [
                'id' => $participant->getHashedKey(),
                'first_name'=> $participant->first_name,
                'last_name' => $participant->last_name,
                'is_admin' => $participant->is_admin
            ];
        }
        return $data;
    }
}
