<?php

namespace App\Containers\AppSection\Financial\Tasks\ImportClubData;

use App\Ship\Parents\Tasks\Task;
use App\Containers\AppSection\Financial\Data\Repositories\{
    FactNameRepository,
    FactValueRepository
};
use App\Containers\AppSection\Financial\Helpers as helpers;
use App\Containers\AppSection\System\Data\Repositories\{
    CountryRepository,
    SportClubRepository,
    SportLeagueRepository,
    SportRepository
};
use App\Containers\AppSection\System\Models\{
    SportClub,
    SportLeague,
    Country,
    Sport
};

abstract class BaseTask extends Task
{
    protected FactNameRepository $factRepository;
    protected FactValueRepository $dataRepository;
    private $importType = '';
    private $someImportData = [
        'facts' => [
            'task' => 'FactDataTask',
        ],
        'financial' => [
            'task' => 'FinancialDataTask',
        ],
        'financial_new' => [
            'task' => 'FinancialDataTask',
        ],
    ];

    public function __construct(FactNameRepository $factRepository, FactValueRepository $dataRepository)
    {
        $this->factRepository = $factRepository;
        $this->dataRepository = $dataRepository;
    }

    /**
     * @param string $importType
     */
    public function setImportType(string $importType): void
    {
        $availableTypes = ['facts', 'financial', 'financial_new'];

        if (!in_array($importType, $availableTypes)) {
            die("Wrong import type: $importType");
        }

        $this->importType = $importType;
    }


    public function run($file_path, &$error_message)
    {
        /*Algorithm
        1 Provide initial folder
        2 Foreach sub-folder
            2.1 See if league present
                2.1.1 If not add it (see country)
            2.2 For each file in folder
                2.2.1 Validate club
                2.2.2 See if club present
                    2.2.2.1 If not add it
                2.2.3 Insert data
        */

        echo "\nRunning {$this->someImportData[$this->importType]['task']} for folder: [$file_path]\n";

        if (!is_dir($file_path)) {
            die("Path [$file_path] is not a folder.\n");
        }

        //Fix end slash
        if (substr($file_path, -1) == DIRECTORY_SEPARATOR) {
            $file_path = substr($file_path, 0, strlen($file_path) -1);
        }

        //Get only folder names
        $league_folders_names = array_filter(
            scandir($file_path),
            function($path) use ($file_path) {
                return is_dir($file_path . DIRECTORY_SEPARATOR . $path) && !in_array($path, ['.', '..']);
            }
        );

        //Obtain full path
        $league_folders = array_map(
            function ($path) use ($file_path) {
                return $file_path . DIRECTORY_SEPARATOR . $path;
            },
            $league_folders_names
        );

        print_r($league_folders . "\n");

        //Import each league (subfolder)
        foreach ($league_folders as $league_folder) {
            $league_folder_name = basename($league_folder);
            printf("\nLeague: [$league_folder_name]");

            preg_match('/(.+)\((.+)\)/', $league_folder_name, $matches);
            $league_name  = trim($matches[1]);
            $country_name = trim($matches[2]);

            printf("\n\tCountry: [$country_name] League: [$league_name]");

            //Get Country
            $countryRepo = new CountryRepository(app());
            $country = $countryRepo->findWhere([
                'name' => $country_name
            ])->first();

            if($country ==null || !is_object($country) || !is_numeric($country->id)){
                die("\nCountry $country_name not present");
            } else {
                print("\nCountry $country_name present");
            }

            //Get Sport
            $sportRepo = new SportRepository(app());
            $sport = $sportRepo->findWhere([
                'name' => 'Football'
            ])->first();

            //Check league
            $leagueRepo = new SportLeagueRepository(app());
            $league = $leagueRepo->findWhere([
                'name' => $league_name
            ])->first();
            if($league ==null || !is_object($league) || !is_numeric($league->id)){
                print("\nLeague $league not present");

                //TODO: Add it
                print("TODO: Add it! ");
                $league = $leagueRepo->create([
                    'name'=>$league_name,
                    'sport_id'=>$sport->id
                ]);
                printf("\nLeague %s created with id = %d", $league->name, $league->id);
            }
            else{
                printf("\n\tLeague %s present", $league->name);
            }

            //Validate folder
            switch ($this->importType) {
                case 'facts':
                    helpers\validate_folder(helpers\getValidationMapper(), $league_folder, $errors);
                    break;
                case 'financial':
                    helpers\validate_financial_folder(helpers\getFinancialValidationMapper(), $league_folder, $errors);
                    break;
                case 'financial_new':
                    helpers\validate_financial_folder(helpers\getFinancialNewValidationMapper(), $league_folder, $errors);
                    break;
            }

            if (strlen($errors) > 0) {
                print("\n\n\nImport stoped due to errors: \n");
                print_r($errors);
                die("Die....");
            }

            //Import Clubs
            $club_file_names = array_filter(
                scandir($league_folder),
                function($path) use ($league_folder) {
                    return is_file($league_folder . DIRECTORY_SEPARATOR . $path) && !in_array($path, ['.', '..']) && substr($path, -4, 4) == 'xlsx';
                }
            );
            printf("\n\tClub names's files: %s", implode(',',$club_file_names));

            foreach($club_file_names as $club_file_name){
                $clubFilePath = $league_folder .  DIRECTORY_SEPARATOR . $club_file_name;
                $this->importClub($clubFilePath, $country, $sport, $league);
            }
        }
    }


    /**Imports a Club from a certain path */
    function importClub($clubFilePath, Country $country, Sport $sport, SportLeague $league){
        $clubRepository = new SportClubRepository(app());

        $club_path_parts = pathinfo($clubFilePath);
        $clubName = $club_path_parts['filename'];
        printf("\n\nImporting********************************[%s]************************", $clubName);

        $club = $clubRepository->findWhere([
            'name' => $clubName,
            'country_id' => $country->id,
            'sport_id' => $sport->id,
            'league_id' => $league->id
        ])->first();
        if($club ==null || !is_object($club) || !is_numeric($club->id)){
            print("\nClub $clubName not present in DB. Create it.");

            //TODO: Add it
            $club = $clubRepository->create([
                'name'=>$clubName,
                'country_id'=>$country->id,
                'sport_id'=>$sport->id,
                'league_id' => $league->id
            ]);

            if(!is_object($club) || !is_numeric($club->id) ){
                die("Club not created properly");
            }
        } else {
            print("\nClub $clubName present. Skip import.");
            return;
        }

        $this->importDatas($club, $clubFilePath, $msgs);

        if (strlen($msgs) > 0 ){
            print($msgs);
        }

        return $club;
    }

    function splitCell($cell)
    {
        preg_match('/([A-Z]+)([0-9]+)/', $cell, $matches);
        return [$matches[1], $matches[2]];
    }

    abstract function importDatas(SportClub $club, $clubFilePath, &$error_message);
}
