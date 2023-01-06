<?php

namespace App\Containers\AppSection\UserSponsorship\Actions;

use App\Containers\AppSection\Financial\Enums\FactSectionsName;
use App\Containers\AppSection\Financial\Tasks\GetFactsByNameIdsTask;
use App\Containers\AppSection\System\Data\Repositories\SportBrandRepository;
use App\Containers\AppSection\System\Data\Repositories\SportSponsorRepository;
use App\Containers\AppSection\System\Tasks\GetSystemDataByNameTask;
use App\Containers\AppSection\UserSponsorship\Tasks\CreateClubSponsorTask;
use App\Containers\AppSection\UserSponsorship\Tasks\GetClubSponsorByNameTask;
use App\Ship\Parents\Actions\Action;

class ImportClubSponsorsAction extends Action
{

    protected SportSponsorRepository $sportSponsorRepository;
    protected SportBrandRepository $sportBrandRepository;

    public function __construct(SportSponsorRepository $sportSponsorRepository, SportBrandRepository $sportBrandRepository)
    {
        $this->sportSponsorRepository = $sportSponsorRepository;
        $this->sportBrandRepository = $sportBrandRepository;
    }

    public function run()
    {
        $factsIds = FactSectionsName::clubFactsIds();

       $facts = app(GetFactsByNameIdsTask::class)->run($factsIds);

       foreach ($facts as $fact) {
           if(strlen($fact->value) >= 2) {
               $explodedFact = explode(',', $fact->value);
               foreach ($explodedFact as $value) {
                   $value = trim($value);
                   $clubSponsor = app(GetClubSponsorByNameTask::class)->run($value);
                   if(!$clubSponsor && $value != '') {
                       $sponsor = app(GetSponsorOrBrandByNameSubAction::class)->run($value);

                       app(CreateClubSponsorTask::class)->run([
                           'name' => $value,
                           'logo' => $sponsor ? $sponsor->logo : null
                       ]);
                   }
               }
           }
       }
    }
}
