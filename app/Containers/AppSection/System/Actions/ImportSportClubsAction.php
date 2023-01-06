<?php

namespace App\Containers\AppSection\System\Actions;

use App\Containers\AppSection\System\Models\SportClub;
use App\Containers\AppSection\System\Tasks\ReadCsvToImportSportClubsTask;
use App\Containers\AppSection\System\Tasks\FindCountryByNameTask;
use App\Containers\AppSection\System\Tasks\FindSportLeagueTask;
use App\Containers\AppSection\System\Tasks\CreateSportLeagueTask;
use App\Containers\AppSection\System\Tasks\FindSportClubTask;
use App\Containers\AppSection\System\Tasks\CreateSportClubTask;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class ImportSportClubsAction extends Action
{
    public function run($sport_id, $file_path)
    {
        $summary_import = [
            'league_inserted' => 0,
            'league_found' => 0,
            'club_inserted' => 0,
            'inserted' => 0,
            'club_found' => 0,
            'status' => true,
            'error_message' => ''
        ];

        $error_message = '';
        $csv_data = app(ReadCsvToImportSportClubsTask::class)->run($file_path, $error_message);

        if (!$csv_data || count($csv_data) == 0) {
            $summary_import['error_message'] = $error_message;
            $summary_import['status'] = false;
            return $summary_import;
        }

        $countries = $this->GetCountries($csv_data, $summary_import);
        if (!$countries || !is_array($countries)) {
            return $summary_import;
        }
        $leagues = $this->FindOrInsertCountries($csv_data, $summary_import, $sport_id);

        foreach ($csv_data as $row) {
            $league = $leagues[$row['league']];
            $country = $countries[$row['country']];
            $club_data = [
                'name' => $row['team'],
                'league_id' => $league['id'],
                'country_id' => $country['id']
            ];

            $club = app(FindSportClubTask::class)->run($club_data)->first();
            if (!$club) {
                app(CreateSportClubTask::class)->run($club_data);
                $summary_import['club_inserted']++;
            } else {
                $summary_import['club_found']++;
            }
        }

        return $summary_import;
    }

    private function GetCountries($csv_data, &$summary_import)
    {
        $countries_names = array_column($csv_data, 'country');

        $countries = [];
        foreach (array_unique($countries_names) as $country_name) {
            $country = app(FindCountryByNameTask::class)->run($country_name);
            if (!$country) {
                $summary_import['error_message'] = 'The country ' . $country_name . ' not found!';
                $summary_import['status'] = false;
                return false;
            }

            $countries[$country_name] = $country->toArray();
        }

        return $countries;
    }

    private function FindOrInsertCountries($csv_data, &$summary_import, $sport_id)
    {
        $leagues_names = array_column($csv_data, 'league');

        $leagues = [];
        foreach (array_unique($leagues_names) as $league_name) {
            $league_data = [
                'name' => $league_name,
                'sport_id' => $sport_id
            ];

            $league = app(FindSportLeagueTask::class)->run($league_data)->first();
            if (!$league) {
                $league = app(CreateSportLeagueTask::class)->run($league_data);
                $summary_import['league_inserted']++;
            } else {
                $summary_import['league_found']++;
            }

            $leagues[$league_name] = $league->toArray();
        }

        return $leagues;
    }
}
