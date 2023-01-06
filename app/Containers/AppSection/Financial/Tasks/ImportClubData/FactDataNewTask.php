<?php

namespace App\Containers\AppSection\Financial\Tasks\ImportClubData;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Containers\AppSection\Financial\Data\Repositories\{
    FactNameRepository,
    FactSectionRepository,
    FactValueRepository,
    FactIntervalRepository
};
use App\Containers\AppSection\System\Models\SportClub;
use App\Containers\AppSection\Financial\Tasks\ImportClubData\BaseTask as BaseImportTask;

class FactDataNewTask extends BaseImportTask
{
    public function run($file_path, &$error_message = '')
    {
        $this->setImportType('facts');
        parent::run($file_path, $error_message);
    }

    private static function getMap()
    {
        return [
            'C2' => ['fact_name'=>'B2', 'hint'=>'Official club name'], //Official club name:
            'C3' => ['fact_name'=>'B3', 'hint'=>'Address'], //Address
            'C4' => ['fact_name'=>'B3', 'hint'=>'Address'], //Address
            'C5' => ['fact_name'=>'B3', 'hint'=>'Address'], //Address
            'C6' => ['fact_name'=>'B6', 'hint'=>'Tel'], //Tel
            'C7' => ['fact_name'=>'B7', 'hint'=>'Fax'], //Fax
            'C8' => ['fact_name'=>'B8', 'hint'=>'Site'], //Site
            'C9' => ['fact_name'=>'B9', 'hint'=>'Founded'], //Founded
            'C10' => ['fact_name'=>'B10', 'hint'=>'Members'], //Members
            'C11' => ['fact_name'=>'B11', 'hint'=>'Owner(s)'], //Owner(s)
            'C12' => ['fact_name'=>'B12', 'hint'=>'President (Chairman):'], //President (Chairman):
            'C13' => ['fact_name'=>'B13', 'hint'=>'Manager'], //Manager
            'C14' => ['fact_name'=>'B14', 'hint'=>'No. Employees'], //No. Employees
            'C15' => ['fact_name'=>'B15', 'hint'=>'Squad size:'], //Squad size:
            'C16' => ['fact_name'=>'B16', 'hint'=>'Average age:'], //Average age: 
            'C17' => ['fact_name'=>'B17', 'hint'=>'Foreign Players:'], //Foreign Players:
            'C18' => ['fact_name'=>'B18', 'hint'=>'Foreign Players % of Squad:'], //Foreign Players % of Squad:
            'C19' => ['fact_name'=>'B19', 'hint'=>'Nation Team Players:'], //Nation Team Players:
            'C20' => ['fact_name'=>'B20', 'hint'=>'Stadium Name:'], //Stadium Name:
            'C21' => ['fact_name'=>'B21', 'hint'=>'Capacity:'], //Capacity:
            'C22' => ['fact_name'=>'B22', 'hint'=>'Premier League'], //Premier League
            'C23' => ['fact_name'=>'B23', 'hint'=>'Number of years in league:'], //Number of years in league:
            'C24' => ['fact_name'=>'B24', 'hint'=>'Total Market Value (in pounds)'], //Total Market Value (in pounds)

            //Main Club Honours
            'C28' => ['fact_name'=>'B28', 'fact_section'=>'C27', 'hint'=>'League Titles'], //League Titles
            'C29' => ['fact_name'=>'B29', 'fact_section'=>'C27', 'hint'=>'National Cup'], //National Cup
            'C30' => ['fact_name'=>'B30', 'fact_section'=>'C27', 'hint'=>'Champions League'], //Champions League
            'C31' => ['fact_name'=>'B31', 'fact_section'=>'C27', 'hint'=>'Europa Leagues'], //Europa Leagues
            'C32' => ['fact_name'=>'B32', 'fact_section'=>'C27', 'hint'=>'Europa Conference'], //Europa Conference

            //Current Sponsors
            'C35' => ['fact_name'=>'B35', 'fact_section'=>'C34', 'hint'=>'Shirt'], //Shirt
            'C36' => ['fact_name'=>'B36', 'fact_section'=>'C34', 'hint'=>'Sleeve'], //Sleeve
            'C37' => ['fact_name'=>'B37', 'fact_section'=>'C34', 'hint'=>'Kit'], //Kit
            'C38' => ['fact_name'=>'B38', 'fact_section'=>'C34', 'hint'=>'Main current partners'], //Main current partners

            //Social Media
            'C41' => ['fact_name'=>'B41', 'fact_section'=>'C40', 'hint'=>'Facebook'], //Facebook
            'C42' => ['fact_name'=>'B42', 'fact_section'=>'C40', 'hint'=>'Instagram'], //Instagram
            'C43' => ['fact_name'=>'B43', 'fact_section'=>'C40', 'hint'=>'Twitter'], //Twitter
            'C44' => ['fact_name'=>'B44', 'fact_section'=>'C40', 'hint'=>'Linkedin'], //Linkedin


            //Competition Position Finish
            'D48-G52' => [
                'fact_names'=>['C48','C49', 'C50', 'C51', 'C52'],
                'fact_section'=>'C47',
                'fact_intervals'=>['D47', 'E47', 'F47', 'G47'],
                'hint'=>'Competition Position Finish'
            ],

            //Player Trading
            'D56-G60' => [
                'fact_names'=>['C56','C57', 'C58', 'C59', 'C60'],
                'fact_section'=>'D54',
                'fact_intervals'=>['D47', 'E47', 'F47', 'G47'],
                'hint'=>'Player Trading'
            ],

            //Managers per year
            'D63-G63' => [
                'fact_names'=>['C63'],
                'fact_section'=>'C63', //fact section is also a fact name
                'fact_intervals'=>['D47', 'E47', 'F47', 'G47'],
                'hint'=>'Managers per year'
            ],


        ];
    }

    /**
     * Import datas for a club
     */
    function importDatas(SportClub $club, $clubFilePath, &$error_message)
    {
        printf("\nImport facts for club [name: %s] [id: %d]", $club->name, $club->id);

        $map = self::getMap();

        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = IOFactory::load($clubFilePath);

        $result = true;
        foreach ($map as $cell => $details) {
            printf("\n\tCell: " . $cell);
            if (strpos($cell, '-') === FALSE ) { //simple cell
                $this->importData($club, $cell, $details, $spreadsheet);
            } else { //range
                list($startCell, $endCell) = explode('-', $cell, 2);
                printf("\n\tStarting cell: [%s], ending cell: [%s]", $startCell, $endCell);

                list($startLetter, $startNumber) = $this->splitCell($startCell);
                printf("\n\tStarting letter [%s], starting number [%d]", $startLetter, $startNumber);

                list($endLetter, $endNumber) = $this->splitCell($endCell);
                printf("\n\tEnd letter [%s], end number [%d]", $endLetter, $endNumber);

                printf("\n\tCells are:");

                for ($number = $startNumber; $number <= $endNumber; $number++) {
                    for ($letter_code = ord($startLetter); $letter_code <= ord($endLetter); $letter_code++) {
                        $letter = chr($letter_code);
                        $current_cell = $letter . $number;
                        print($current_cell . ' ');
                        $current_details = [
                            'fact_section'  => $details['fact_section'],
                            'fact_name'     => $details['fact_names'][$number-$startNumber],
                            'fact_interval' => $details['fact_intervals'][$letter_code-ord($startLetter)],
                            'hint'          => $details['hint']
                        ];
                        $this->importData($club, $current_cell, $current_details, $spreadsheet);
                    }
                }
            }
        }

        return $result;
    }

    function importData($club, $cell, $details, $spreadsheet)
    {
        $factNameRepository     = new FactNameRepository(app());
        $factSectionRepository  = new FactSectionRepository(app());
        $factIntervalRepository = new FactIntervalRepository(app());
        $factValueRepository    = new FactValueRepository(app());

        print("\n\tFact: " . $cell . "\n");

        $fact_name = $spreadsheet->getActiveSheet()->getCell($details['fact_name'])->getValue();

        //groom fact name
        $fact_name = str_replace(':', '', $fact_name);

        //Section
        $section_present = false;
        $fs = null;
        if (isset($details['fact_section']) &&  strlen(trim($details['fact_section'])) > 0 ) {
            $section_present = true;

            $fact_section_name = $spreadsheet->getActiveSheet()->getCell($details['fact_section'])->getValue();

            printf("\n\tSearching for section [%s]", $fact_section_name);

            $fs = $factSectionRepository->findWhere([
                'name' => $fact_section_name
            ])->first();

            if (!is_object($fs) || !is_numeric($fs->id)) {

                print(sprintf("\n\tWARNING!Fact section [%s] not present in the DB. Found [%s] instead of [%s]",
                    $fact_section_name,
                    $fact_section_name,
                    $details['hint']
                ));
                return;
            } else {
                printf("\n\tFound section [%s] [%d]", $fs->name, $fs->id);
            }
        }

        //Interval
        $interval_present = false;
        $fi = null;
        if (isset($details['fact_interval']) &&  strlen(trim($details['fact_interval'])) > 0 ) {
           $interval_present = true;
           $fact_interval_value = $spreadsheet->getActiveSheet()->getCell($details['fact_interval'])->getValue();

           printf("\n\tSearching for interval [%s]", $fact_interval_value);

           $fi = $factIntervalRepository->findWhere([
               'interval' => $fact_interval_value
           ])->first();

           if (!is_object($fi) || !is_numeric($fi->id)) {
               die(sprintf('\n\tFact interval [%s] not present in the DB', $fact_interval_value));
           } else {
               printf("\n\tFound interval [%s] [%d]", $fi->interval, $fi->id);
           }
        }

        //Find FactName
        $factname_criteria = ['name' => $fact_name];
        if ($section_present) {
            $factname_criteria['factsection_id'] = $fs->id;
        }

        $fn = $factNameRepository->findWhere($factname_criteria)->first();

        //Create FactName if missing (Dangerous!)
        if (!is_object($fn) || !is_numeric($fn->id)) {
            $factname_raw = ['name' => $fact_name];

            if ($section_present) {
                $factname_raw['factsection_id'] = $fs->id;
            }

            $fn = $factNameRepository->create($factname_raw);
            printf("\n\tCreated FactName name=[%s] id=[%d] section=[%d]", $fn->name, $fn->id, $fn->factsection_id);
        }

        //============FactValue=======================
        $cell_value = $spreadsheet->getActiveSheet()->getCell($cell)->hasHyperlink()
            ? $spreadsheet->getActiveSheet()->getCell($cell)->getHyperlink()->getUrl()
            : $spreadsheet->getActiveSheet()->getCell($cell)->getFormattedValue();

        printf("\n\tCreating the FactValue. Fact name = [%s], club id = [%d], value = [%s], interval=[%s]", $fn->name, $club->id, $cell_value, $interval_present?$fi->interval:'n/a');

        if (strlen(trim($cell_value)) == 0) //skip empty values
            return;

        //Find FactValue. If present append if not create
        $fact_value_criteria = [
            'fact_name_id' => $fn->id,
            'club_id' => $club->id
        ];

        if ($interval_present) {
            $fact_value_criteria['fact_interval_id'] = $fi->id;
        }

        $fact_value = $factValueRepository->findWhere($fact_value_criteria)->first();

        if (is_object($fact_value) && is_numeric($fact_value->id)) {
            //update
            printf("\n\tUpdating FactValue id=[%d] value=[%s]", $fact_value->id, $fact_value->value);

            $factValueRepository->update([
                    'value' => $fact_value->value . ' ' . $cell_value
                ],
                $fact_value->id
            );
        } else {
            //create
            $fact_value_raw = [
                'fact_name_id' => $fn->id,
                'club_id' => $club->id,
                'value' => $cell_value
            ];

            if ($interval_present) {
                $fact_value_raw['fact_interval_id'] = $fi->id;
            }

            $factValueRepository->create($fact_value_raw);
        }
    }
}
