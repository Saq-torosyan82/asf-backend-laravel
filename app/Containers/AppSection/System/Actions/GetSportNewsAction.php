<?php

namespace App\Containers\AppSection\System\Actions;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\System\Tasks\GetSportNewsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetSportNewsAction extends Action
{
    use HashIdTrait;
    public function run(Request $request)
    {
        $sportIds = $countriesIds = [];
        if ($request->sports) {
            $sports = !is_array($request->sports) ? [$request->sports] : $request->sports;
            foreach ($sports as $sport) {
                $id = $this->decode($sport);
                if (!empty($id)) {
                    $sportIds[] = $id;
                }
            }
        }
        if ($request->countries) {
            $countries = !is_array($request->countries) ? [$request->countries] : $request->countries;
            foreach ($countries as $country) {
                $id = $this->decode($country);
                if (!empty($id)) {
                    $countriesIds[] = $id;
                }
            }
        }

        return app(GetSportNewsTask::class)->addRequestCriteria()->order()->sportIds($sportIds)->countryIds($countriesIds)->run(true);

    }
}
