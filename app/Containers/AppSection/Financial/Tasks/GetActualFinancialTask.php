<?php

namespace App\Containers\AppSection\Financial\Tasks;

use App\Containers\AppSection\Financial\Data\Repositories\FinancialRepository;
use App\Containers\AppSection\Financial\Data\Repositories\FinancialSeasonRepository;
use App\Containers\AppSection\UserProfile\Data\Repositories\UserProfileRepository;
use App\Containers\AppSection\UserProfile\Enums\Group;
use App\Containers\AppSection\UserProfile\Enums\Key;
use App\Ship\Parents\Tasks\Task;
use Auth;

class GetActualFinancialTask extends Task
{
    protected FinancialRepository $repository;
    protected FinancialSeasonRepository $seasonRepository;
    protected UserProfileRepository $userRepository;

    public function __construct(FinancialRepository $repository, FinancialSeasonRepository $seasonRepository,
                                UserProfileRepository $userRepository)
    {
        $this->repository = $repository;
        $this->seasonRepository = $seasonRepository;
        $this->userProfileRepository = $userRepository;
    }

    public function run($club_id = null)
    {
        if(!$club_id) {
            $user_id = Auth::user()->id;
            $club_id = $this->userProfileRepository->where('group', Group::PROFESSIONAL)
                ->where('key', Key::CLUB)
                ->where('user_id', $user_id)
                ->first()->value;
        }
        $financials = app(FindFinancialsTask::class)->run(['club_id' => $club_id]);

        if (count($financials) != 0 && $financials[0]->season_id != null && $financials[0]->is_blocked == 0) {
            $season = $this->seasonRepository->find($financials[0]->season_id);
            if (!empty($season)) {
                [$start, $end] = explode('/', $season->label);

                if ($end == date('y')) {
                    return $financials[0];
                }
            }
        }
    }
}
