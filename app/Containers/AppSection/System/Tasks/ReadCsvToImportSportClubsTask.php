<?php

namespace App\Containers\AppSection\System\Tasks;

use App\Ship\Parents\Tasks\Task;

class ReadCsvToImportSportClubsTask extends Task
{
    public function run($file_path, &$error_message)
    {
        if(!file_exists($file_path)) {
            $error_message = 'File not found!';
            return false;
        }

        if(strtolower(pathinfo($file_path, PATHINFO_EXTENSION)) != "csv") {
            $error_message = 'File is not a CSV!';
            return false;
        }

        $file_handle = fopen($file_path, 'r');
        $csv_data = [];

        fgetcsv($file_handle, 0, ',');
        while (!feof($file_handle)) {
            $csv_row = fgetcsv($file_handle, 0, ',');
            if($csv_row) {
                $csv_data[] = [
                    'team' => trim(trim($csv_row[0]), '.'),
                    'league' => trim(trim($csv_row[1]), '.'),
                    'country' => trim(trim($csv_row[2]), '.') 
                ];
            }   
        }
        fclose($file_handle);
        return $csv_data;
    }
}
