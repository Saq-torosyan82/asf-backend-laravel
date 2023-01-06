<?php

namespace App\Containers\AppSection\Financial\Tasks\ImportClubData;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Containers\AppSection\Financial\Data\Repositories\{
    FinancialItemRepository,
    FinancialDataRepository,
    FinancialRepository,
    FinancialSeasonRepository
};

use App\Containers\AppSection\System\Models\SportClub;
use App\Containers\AppSection\Financial\Tasks\ImportClubData\BaseTask as BaseImportTask;

class FinancialDataTask extends BaseImportTask
{
    public function run($file_path, &$error_message)
    {
        $this->setImportType('financial');
        parent::run($file_path, $error_message);
    }

    private static function getMap()
    {
        return [
            // -------------------------------- Sheet 1----------------------------------------
            [
                //Total operating revenue (A)
                'C3' => ['sheet'=>0, 'item_name'=>'B3', 'season' => 'C2', 'hint'=>'Total operating revenue (A)'],
                'D3' => ['sheet'=>0, 'item_name'=>'B3', 'season' => 'D2', 'hint'=>'Total operating revenue (A)'],

                'C4' => ['sheet'=>0, 'item_name'=>'B4', 'season' => 'C2', 'hint'=>''],
                'D4' => ['sheet'=>0, 'item_name'=>'B4', 'season' => 'D2', 'hint'=>''],

                'C5' => ['sheet'=>0, 'item_name'=>'B5', 'season' => 'C2', 'hint'=>''],
                'D5' => ['sheet'=>0, 'item_name'=>'B5', 'season' => 'D2', 'hint'=>''],

                'C6' => ['sheet'=>0, 'item_name'=>'B6', 'season' => 'C2', 'hint'=>''],
                'D6' => ['sheet'=>0, 'item_name'=>'B6', 'season' => 'D2', 'hint'=>''],

                'C7' => ['sheet'=>0, 'item_name'=>'B7', 'season' => 'C2', 'hint'=>''],
                'D7' => ['sheet'=>0, 'item_name'=>'B7', 'season' => 'D2', 'hint'=>''],

                'C8' => ['sheet'=>0, 'item_name'=>'B8', 'season' => 'C2', 'hint'=>''],
                'D8' => ['sheet'=>0, 'item_name'=>'B8', 'season' => 'D2', 'hint'=>''],

                'C9' => ['sheet'=>0, 'item_name'=>'B9', 'season' => 'C2', 'hint'=>''],
                'D9' => ['sheet'=>0, 'item_name'=>'B9', 'season' => 'D2', 'hint'=>''],

                'C10' => ['sheet'=>0, 'item_name'=>'B10', 'season' => 'C2', 'hint'=>''],
                'D10' => ['sheet'=>0, 'item_name'=>'B10', 'season' => 'D2', 'hint'=>''],

                //Total player trading (D)
                'C12' => ['sheet'=>0, 'item_name'=>'B12', 'season' => 'C2', 'hint'=>'Total player trading (D)'],
                'D12' => ['sheet'=>0, 'item_name'=>'B12', 'season' => 'D2', 'hint'=>'Total player trading (D)'],

                'C13' => ['sheet'=>0, 'item_name'=>'B13', 'season' => 'C2', 'hint'=>''],
                'D13' => ['sheet'=>0, 'item_name'=>'B13', 'season' => 'D2', 'hint'=>''],

                'C14' => ['sheet'=>0, 'item_name'=>'B14', 'season' => 'C2', 'hint'=>''],
                'D14' => ['sheet'=>0, 'item_name'=>'B14', 'season' => 'D2', 'hint'=>''],

                'C15' => ['sheet'=>0, 'item_name'=>'B15', 'season' => 'C2', 'hint'=>''],
                'D15' => ['sheet'=>0, 'item_name'=>'B15', 'season' => 'D2', 'hint'=>''],

                'C16' => ['sheet'=>0, 'item_name'=>'B16', 'season' => 'C2', 'hint'=>''],
                'D16' => ['sheet'=>0, 'item_name'=>'B16', 'season' => 'D2', 'hint'=>''],

                'C17' => ['sheet'=>0, 'item_name'=>'B17', 'season' => 'C2', 'hint'=>''],
                'D17' => ['sheet'=>0, 'item_name'=>'B17', 'season' => 'D2', 'hint'=>''],

                //Net Total interest receivable/payable (F)
                'C19' => ['sheet'=>0, 'item_name'=>'B19', 'season' => 'C2', 'hint'=>'Net Total interest receivable/payable (F)'],
                'D19' => ['sheet'=>0, 'item_name'=>'B19', 'season' => 'D2', 'hint'=>''],

                'C20' => ['sheet'=>0, 'item_name'=>'B20', 'season' => 'C2', 'hint'=>''],
                'D20' => ['sheet'=>0, 'item_name'=>'B20', 'season' => 'D2', 'hint'=>''],

                'C21' => ['sheet'=>0, 'item_name'=>'B21', 'season' => 'C2', 'hint'=>''],
                'D21' => ['sheet'=>0, 'item_name'=>'B21', 'season' => 'D2', 'hint'=>''],

                'C22' => ['sheet'=>0, 'item_name'=>'B22', 'season' => 'C2', 'hint'=>''],
                'D22' => ['sheet'=>0, 'item_name'=>'B22', 'season' => 'D2', 'hint'=>''],

                'C23' => ['sheet'=>0, 'item_name'=>'B23', 'season' => 'C2', 'hint'=>''],
                'D23' => ['sheet'=>0, 'item_name'=>'B23', 'season' => 'D2', 'hint'=>''],
            ],


            // -------------------------------- Sheet 2----------------------------------------
            [
                //Total assets
                'C3' => ['sheet'=>1, 'item_name'=>'B3', 'season' => 'C2', 'hint'=>'Total operating revenue (A)'],
                'D3' => ['sheet'=>1, 'item_name'=>'B3', 'season' => 'D2', 'hint'=>'Total operating revenue (A)'],

                'C4' => ['sheet'=>1, 'item_name'=>'B4', 'season' => 'C2', 'hint'=>''],
                'D4' => ['sheet'=>1, 'item_name'=>'B4', 'season' => 'D2', 'hint'=>''],

                'C5' => ['sheet'=>1, 'item_name'=>'B5', 'season' => 'C2', 'hint'=>''],
                'D5' => ['sheet'=>1, 'item_name'=>'B5', 'season' => 'D2', 'hint'=>''],

                'C6' => ['sheet'=>1, 'item_name'=>'B6', 'season' => 'C2', 'hint'=>''],
                'D6' => ['sheet'=>1, 'item_name'=>'B6', 'season' => 'D2', 'hint'=>''],

                'C7' => ['sheet'=>1, 'item_name'=>'B7', 'season' => 'C2', 'hint'=>''],
                'D7' => ['sheet'=>1, 'item_name'=>'B7', 'season' => 'D2', 'hint'=>''],

                'C8' => ['sheet'=>1, 'item_name'=>'B8', 'season' => 'C2', 'hint'=>''],
                'D8' => ['sheet'=>1, 'item_name'=>'B8', 'season' => 'D2', 'hint'=>''],

                'C9' => ['sheet'=>1, 'item_name'=>'B9', 'season' => 'C2', 'hint'=>''],
                'D9' => ['sheet'=>1, 'item_name'=>'B9', 'season' => 'D2', 'hint'=>''],

                'C10' => ['sheet'=>1, 'item_name'=>'B10', 'season' => 'C2', 'hint'=>'2. Fixed assets'],
                'D10' => ['sheet'=>1, 'item_name'=>'B10', 'season' => 'D2', 'hint'=>''],

                'C11' => ['sheet'=>1, 'item_name'=>'B11', 'season' => 'C2', 'hint'=>''],
                'D11' => ['sheet'=>1, 'item_name'=>'B11', 'season' => 'D2', 'hint'=>''],

                'C12' => ['sheet'=>1, 'item_name'=>'B12', 'season' => 'C2', 'hint'=>''],
                'D12' => ['sheet'=>1, 'item_name'=>'B12', 'season' => 'D2', 'hint'=>''],

                'C13' => ['sheet'=>1, 'item_name'=>'B13', 'season' => 'C2', 'hint'=>'3. Other fixed assets'],
                'D13' => ['sheet'=>1, 'item_name'=>'B13', 'season' => 'D2', 'hint'=>''],


                //TOTAL LIABILITIES
                'C14' => ['sheet'=>1, 'item_name'=>'B14', 'season' => 'C2', 'hint'=>''],
                'D14' => ['sheet'=>1, 'item_name'=>'B14', 'season' => 'D2', 'hint'=>''],

                'C15' => ['sheet'=>1, 'item_name'=>'B15', 'season' => 'C2', 'hint'=>'1. Current liabilities'],
                'D15' => ['sheet'=>1, 'item_name'=>'B15', 'season' => 'D2', 'hint'=>''],

                'C16' => ['sheet'=>1, 'item_name'=>'B16', 'season' => 'C2', 'hint'=>''],
                'D16' => ['sheet'=>1, 'item_name'=>'B16', 'season' => 'D2', 'hint'=>''],

                'C17' => ['sheet'=>1, 'item_name'=>'B17', 'season' => 'C2', 'hint'=>''],
                'D17' => ['sheet'=>1, 'item_name'=>'B17', 'season' => 'D2', 'hint'=>''],

                'C19' => ['sheet'=>1, 'item_name'=>'B19', 'season' => 'C2', 'hint'=>''],
                'D19' => ['sheet'=>1, 'item_name'=>'B19', 'season' => 'D2', 'hint'=>''],

                'C20' => ['sheet'=>1, 'item_name'=>'B20', 'season' => 'C2', 'hint'=>''],
                'D20' => ['sheet'=>1, 'item_name'=>'B20', 'season' => 'D2', 'hint'=>''],

                'C21' => ['sheet'=>1, 'item_name'=>'B21', 'season' => 'C2', 'hint'=>''],
                'D21' => ['sheet'=>1, 'item_name'=>'B21', 'season' => 'D2', 'hint'=>''],

                'C22' => ['sheet'=>1, 'item_name'=>'B22', 'season' => 'C2', 'hint'=>'2. Long-term liabilities'],
                'D22' => ['sheet'=>1, 'item_name'=>'B22', 'season' => 'D2', 'hint'=>''],

                'C23' => ['sheet'=>1, 'item_name'=>'B23', 'season' => 'C2', 'hint'=>''],
                'D23' => ['sheet'=>1, 'item_name'=>'B23', 'season' => 'D2', 'hint'=>''],

                'C24' => ['sheet'=>1, 'item_name'=>'B24', 'season' => 'C2', 'hint'=>''],
                'D24' => ['sheet'=>1, 'item_name'=>'B24', 'season' => 'D2', 'hint'=>''],

                'C25' => ['sheet'=>1, 'item_name'=>'B25', 'season' => 'C2', 'hint'=>''],
                'D25' => ['sheet'=>1, 'item_name'=>'B25', 'season' => 'D2', 'hint'=>''],

                'C26' => ['sheet'=>1, 'item_name'=>'B26', 'season' => 'C2', 'hint'=>''],
                'D26' => ['sheet'=>1, 'item_name'=>'B26', 'season' => 'D2', 'hint'=>''],

                'C27' => ['sheet'=>1, 'item_name'=>'B27', 'season' => 'C2', 'hint'=>''],
                'D27' => ['sheet'=>1, 'item_name'=>'B27', 'season' => 'D2', 'hint'=>''],

                'C28' => ['sheet'=>1, 'item_name'=>'B28', 'season' => 'C2', 'hint'=>''],
                'D28' => ['sheet'=>1, 'item_name'=>'B28', 'season' => 'D2', 'hint'=>''],

                'C29' => ['sheet'=>1, 'item_name'=>'B29', 'season' => 'C2', 'hint'=>''],
                'D29' => ['sheet'=>1, 'item_name'=>'B29', 'season' => 'D2', 'hint'=>''],

                'C30' => ['sheet'=>1, 'item_name'=>'B30', 'season' => 'C2', 'hint'=>'3. Equity'],
                'D30' => ['sheet'=>1, 'item_name'=>'B30', 'season' => 'D2', 'hint'=>''],

                'C31' => ['sheet'=>1, 'item_name'=>'B31', 'season' => 'C2', 'hint'=>''],
                'D31' => ['sheet'=>1, 'item_name'=>'B31', 'season' => 'D2', 'hint'=>''],
            ]
        ];
    }

    /**
     * Import datas for a club
     */
    function importDatas(SportClub $club, $clubFilePath, &$error_message)
    {
        printf("\n\tImport financial for club [name: %s] [id: %d]", $club->name, $club->id);
        $ignoreEmptyCells = true;

        $map = self::getMap();

        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = IOFactory::load($clubFilePath);

        $result = true;
        foreach ($map as $sheet) {
            foreach($sheet as $cell => $details){
                printf("\n\t\tCell: " . $cell);
                $this->importData($club, $cell, $details, $spreadsheet);
            }
        }
        return $result;
    }

    function importData($club, $cell, $details, $spreadsheet)
    {
        $financialRepo     = new FinancialRepository(app());
        $financialItemRepo = new FinancialItemRepository(app());
        $financialDataRepo = new FinancialDataRepository(app());
        $financialSeasons  = new FinancialSeasonRepository(app());
        $sheet             = $spreadsheet->getSheet($details['sheet']);
        $item_name         = $sheet->getCell($details['item_name'])->getValue();
        $item_value        = $sheet->getCell($cell)->getCalculatedValue();
        $item_season       = $sheet->getCell($details['season'])->getValue();

        printf("\n\t\t\tName: %s, Value: %s, Season: %s", $item_name, $item_value, $item_season);

        //Find Season
        $season_criteria = [
            'label' => $item_season,
        ];

        $season =  $financialSeasons->findWhere($season_criteria)->first();

        printf("\n\t\t\tSeason: %s", $season->label);

        if ($season == null) {
            die("Season doesn't exist");
        }

        //Find Financial
        $financial_data = [
            'club_id' => $club->id,
            'season_id' => $season->id
        ];
        $financial =  $financialRepo->findWhere($financial_data)->first();
        if ($financial == null) {
            //financial is missing
            //TODO: add it
            $financial = $financialRepo->create($financial_data);
        }

        printf("\n\t\t\Financial id: %d", $financial->id);

        //Find financial item
        $financial_item_data = [
            'label' => $item_name
        ];
        $financial_item =  $financialItemRepo->findWhere($financial_item_data)->first();
        if ($financial_item == null) {
            //financial is missing
            // $financial_item_raw = [
            //     'club_id' => $club->id,
            //     'season_id' => $season->id,
            // ];
            // $financial_item = $financialItemRepo->create($financial_item_raw);
            die("\n\t\t Financial item: [$item_name] is missing");
        }

        //Add item
        $financial_data_raw = [
            'financial_id' => $financial->id,
            'item_id' => $financial_item->id,
            'amount' => $item_value
        ];
        $financial_data = $financialDataRepo->create($financial_data_raw);
        printf("\n\t\t\tFinancial data created (id=%d, amount=%f)", $financial_data->id, $financial_data->amount);
        //     $factNameRepository = new FactNameRepository(app());
        //     $factSectionRepository = new FactSectionRepository(app());
        //     $factIntervalRepository = new FactIntervalRepository(app());
        //     $factValueRepository = new FactValueRepository(app());
        //     print("\n\tFact: " . $cell . "\n");
        //         // print_r($details);
        //         $fact_name = $spreadsheet->getActiveSheet()->getCell($details['fact_name'])->getValue();
        //         //groom fact name
        //         $fact_name = str_replace(':', '', $fact_name);
        //         //Section
        //         $section_present = false;
        //         $fs = null;
        //         if( isset($details['fact_section']) &&  strlen(trim($details['fact_section'])) > 0 ) {
        //             $section_present = true;
        //             $fact_section_name = $spreadsheet->getActiveSheet()->getCell($details['fact_section'])->getValue();
        //             printf("\n\tSearching for section [%s]", $fact_section_name);
        //             $fs = $factSectionRepository->findWhere([
        //                 'name' => $fact_section_name
        //             ])->first();
        //             if(!is_object($fs) || !is_numeric($fs->id)){
        //                 print(sprintf("\n\tWARNING!Fact section [%s] not present in the DB. Found [%s] instead of [%s]", $fact_section_name, $fact_section_name, $details['hint']));
        //                 return;
        //             }
        //             else{
        //                 printf("\n\tFound section [%s] [%d]", $fs->name, $fs->id);
        //             }
        //         }
        //         // printf("\n\tSection present " . $section_present);
        //         //Interval
        //         $interval_present = false;
        //         $fi = null;
        //         if( isset($details['fact_interval']) &&  strlen(trim($details['fact_interval'])) > 0 ) {
        //             $interval_present = true;
        //             $fact_interval_value = $spreadsheet->getActiveSheet()->getCell($details['fact_interval'])->getValue();
        //             printf("\n\tSearching for interval [%s]", $fact_interval_value);
        //             $fi = $factIntervalRepository->findWhere([
        //                 'interval' => $fact_interval_value
        //             ])->first();
        //             if(!is_object($fi) || !is_numeric($fi->id)){
        //                 die(sprintf('\n\tFact interval [%s] not present in the DB', $fact_interval_value));
        //             }
        //             else{
        //                 printf("\n\tFound interval [%s] [%d]", $fi->interval, $fi->id);
        //             }
        //         }
        //         //Find FactName
        //         $factname_criteria = ['name' => $fact_name];
        //         if($section_present){
        //             $factname_criteria['factsection_id'] = $fs->id;
        //         }
        //         $fn = $factNameRepository->findWhere($factname_criteria)->first();
        //         //Create FactName if missing (Dangerous!)
        //         if(!is_object($fn) || !is_numeric($fn->id)){
        //             $factname_raw = ['name' => $fact_name];
        //             if($section_present){
        //                 $factname_raw['factsection_id'] = $fs->id;
        //             }
        //             $fn = $factNameRepository->create($factname_raw);
        //             printf("\n\tCreated FactName name=[%s] id=[%d] section=[%d]", $fn->name, $fn->id, $fn->factsection_id);
        //         }
        //         //============FactValue=======================
        //         $cell_value = $spreadsheet->getActiveSheet()->getCell($cell)->hasHyperlink()
        //                 ?
        //                 $spreadsheet->getActiveSheet()->getCell($cell)->getHyperlink()->getUrl()
        //                 :
        //                 $spreadsheet->getActiveSheet()->getCell($cell)->getFormattedValue();
        //         printf("\n\tCreating the FactValue. Fact name = [%s], club id = [%d], value = [%s], interval=[%s]",
        //             $fn->name, $club->id, $cell_value, $interval_present?$fi->interval:'n/a');
        //         if(strlen(trim($cell_value)) == 0) //skip empty values
        //             return;
        //         //Find FactValue. If present append if not create
        //         $fact_value_criteria = [
        //             'fact_name_id' => $fn->id,
        //             'club_id' => $club->id
        //         ];
        //         if($interval_present){
        //             $fact_value_criteria['fact_interval_id'] = $fi->id;
        //         }
        //         $fact_value = $factValueRepository->findWhere($fact_value_criteria)->first();
        //         if(is_object($fact_value) && is_numeric($fact_value->id)){
        //             //update
        //             printf("\n\tUpdating FactValue id=[%d] value=[%s]", $fact_value->id, $fact_value->value);
        //             $factValueRepository->update(
        //                 [
        //                     'value' => $fact_value->value . ' ' . $cell_value
        //                 ],
        //                 $fact_value->id
        //             );
        //         }
        //         else{
        //             //create
        //             $fact_value_raw = [
        //                 'fact_name_id' => $fn->id,
        //                 'club_id' => $club->id,
        //                 'value' => $cell_value
        //             ];
        //             if($interval_present){
        //                 $fact_value_raw['fact_interval_id'] = $fi->id;
        //             }
        //             $fact_value = $factValueRepository->create($fact_value_raw);
        //         }
    }
}
