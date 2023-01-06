<?php

namespace App\Containers\AppSection\Financial\Helpers;

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

error_reporting(E_ALL);

if (!function_exists('getValidationMapper')) {
    function getValidationMapper()
    {
        //Mapper used for validating an XLXS file
        $mapper2 = [
            ['fact_cell' => 'B2', 'fact_name' => 'Official club name', 'fact_value' => ''],
            ['fact_cell' => 'B3', 'fact_name' => 'Address', 'fact_value' => ''],
            ['fact_cell' => 'B6', 'fact_name' => 'Tel', 'fact_value' => ''],
            ['fact_cell' => 'B7', 'fact_name' => 'Fax', 'fact_value' => ''],
            ['fact_cell' => 'B8', 'fact_name' => 'Website', 'fact_value' => ''],
            ['fact_cell' => 'B9', 'fact_name' => 'Founded', 'fact_value' => ''],
            ['fact_cell' => 'B10', 'fact_name' => 'Members', 'fact_value' => ''],
            ['fact_cell' => 'B11', 'fact_name' => 'Owner(s)', 'fact_value' => ''],
            ['fact_cell' => 'B12', 'fact_name' => 'President (Chairman)', 'fact_value' => ''],
            ['fact_cell' => 'B13', 'fact_name' => 'Manager', 'fact_value' => ''],
            ['fact_cell' => 'B14', 'fact_name' => 'No. Employees', 'fact_value' => ''],
            ['fact_cell' => 'B15', 'fact_name' => 'Squad size', 'fact_value' => ''],
            ['fact_cell' => 'B16', 'fact_name' => 'Average age', 'fact_value' => ''],
            ['fact_cell' => 'B17', 'fact_name' => 'Foreign Players', 'fact_value' => ''],
            ['fact_cell' => 'B18', 'fact_name' => 'Foreign Players % of Squad', 'fact_value' => ''],
            ['fact_cell' => 'B19', 'fact_name' => 'Nation Team Players', 'fact_value' => ''],
            ['fact_cell' => 'B20', 'fact_name' => 'Stadium Name', 'fact_value' => ''],
            ['fact_cell' => 'B21', 'fact_name' => 'Capacity', 'fact_value' => ''],
            ['fact_cell' => 'B22', 'fact_name' => 'League', 'fact_value' => ''],
            ['fact_cell' => 'B23', 'fact_name' => 'Number of years in league', 'fact_value' => ''],
            ['fact_cell' => 'B24', 'fact_name' => 'Total Market Value (in pounds)', 'fact_value' => ''],
            ['fact_cell' => 'C27', 'fact_name' => 'Main Club Honour', 'fact_value' => ''],
            ['fact_cell' => 'B28', 'fact_name' => 'League Titles', 'fact_value' => ''],
            ['fact_cell' => 'B29', 'fact_name' => 'National Cup', 'fact_value' => ''],
            ['fact_cell' => 'B30', 'fact_name' => 'Champions League', 'fact_value' => ''],
            ['fact_cell' => 'B31', 'fact_name' => 'Europa Leagues', 'fact_value' => ''],
            ['fact_cell' => 'B32', 'fact_name' => 'Europa Conference', 'fact_value' => ''],
            ['fact_cell' => 'C34', 'fact_name' => 'Current Sponsors', 'fact_value' => ''],
            ['fact_cell' => 'B41', 'fact_name' => 'Facebook', 'fact_value' => ''],
            ['fact_cell' => 'B42', 'fact_name' => 'Instagram', 'fact_value' => ''],
            ['fact_cell' => 'B43', 'fact_name' => 'Twitter', 'fact_value' => ''],
            ['fact_cell' => 'B44', 'fact_name' => 'Linkedin', 'fact_value' => ''],

            ['fact_cell' => 'D46', 'fact_name' => 'Year', 'fact_value' => ''],
            ['fact_cell' => 'C47', 'fact_name' => 'Competition Position Finish', 'fact_value' => ''],
            ['fact_cell' => 'D47', 'fact_name' => '2020/21', 'fact_value' => ''],
            ['fact_cell' => 'E47', 'fact_name' => '2019/20', 'fact_value' => ''],
            ['fact_cell' => 'F47', 'fact_name' => '2018/19', 'fact_value' => ''],
            ['fact_cell' => 'G47', 'fact_name' => '2017/18', 'fact_value' => ''],
            ['fact_cell' => 'C48', 'fact_name' => 'League', 'fact_value' => ''],
            ['fact_cell' => 'C49', 'fact_name' => ['FA Cup', 'DFB-Pokal', 'Copa Del Rey'], 'fact_value' => ''],
            ['fact_cell' => 'C50', 'fact_name' => ['EFL Cup', 'Champions League'], 'fact_value' => ''],
            ['fact_cell' => 'C51', 'fact_name' => ['Champions League', 'Europa League'], 'fact_value' => ''],
            ['fact_cell' => 'C52', 'fact_name' => 'Europa League', 'fact_value' => ''],

            ['fact_cell' => 'D54', 'fact_name' => 'Player Trading', 'fact_value' => ''],
            ['fact_cell' => 'D55', 'fact_name' => '2020/21', 'fact_value' => ''],
            ['fact_cell' => 'E55', 'fact_name' => '2019/20', 'fact_value' => ''],
            ['fact_cell' => 'F55', 'fact_name' => '2018/19', 'fact_value' => ''],
            ['fact_cell' => 'G55', 'fact_name' => '2017/18', 'fact_value' => ''],
            ['fact_cell' => 'C56', 'fact_name' => 'Player Bought', 'fact_value' => ''],
            ['fact_cell' => 'C57', 'fact_name' => 'Players Sold', 'fact_value' => ''],
            ['fact_cell' => 'C58', 'fact_name' => 'Net Spend/(Sales)', 'fact_value' => ''],
            ['fact_cell' => 'C59', 'fact_name' => 'Loan Deals - In', 'fact_value' => ''],
            ['fact_cell' => 'C60', 'fact_name' => 'Loan Deals - Out', 'fact_value' => ''],

            ['fact_cell' => 'D62', 'fact_name' => '2020/21', 'fact_value' => ''],
            ['fact_cell' => 'E62', 'fact_name' => '2019/20', 'fact_value' => ''],
            ['fact_cell' => 'F62', 'fact_name' => '2018/19', 'fact_value' => ''],
            ['fact_cell' => 'G62', 'fact_name' => '2017/18', 'fact_value' => ''],
            ['fact_cell' => 'C63', 'fact_name' => 'Managers per year', 'fact_value' => ''],
        ];

        return $mapper2;
    }
}


/**
 * Validates a single file
 * */
if (!function_exists('validate_file')) {
    function validate_file($mapper, $file_path, &$error_message)
    {
        $ignoreEmptyCells = true;

        if (!file_exists($file_path)) {
            $error_message = 'File not found!';
            return false;
        }

        if (strtolower(pathinfo($file_path, PATHINFO_EXTENSION)) != "xlsx") {
            $error_message = 'File is not a XLSX!';
            return false;
        }

        //Load spreadsheet
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = IOFactory::load($file_path);

        $result = true;
        foreach ($mapper as $fact) {
            $currentCellValue = $spreadsheet->getActiveSheet()->getCell($fact['fact_cell'])->getValue();
            if ($currentCellValue == '') {
                if ($ignoreEmptyCells) {
                    //nothing...all good
                } else {
                    $error_message .= "\n\t\tCell " . $fact['fact_cell'] . "  broken. Expected [" . $fact['fact_name'] . "] but got [$currentCellValue]";
                    $result = false;
                }
            } else {
                if (gettype($fact['fact_name']) == 'array') { //if we have multiple variants for a name
                    $result = false;
                    foreach ($fact['fact_name'] as $factName) {
                        if (strpos($currentCellValue, $factName) !== false) {
                            $result = true;
                            break;
                        }
                    }
                    if ($result == false) {
                        $error_message .= "\n\t\tCell " . $fact['fact_cell'] . "  broken. Expected any value from[" . (implode(
                                ',',
                                $fact['fact_name']
                            )) . "] but got [$currentCellValue]";
                    }
                } else {
                    if (strpos($currentCellValue, $fact['fact_name']) === false) {
                        $error_message .= "\n\t\tCell " . $fact['fact_cell'] . "  broken. Expected [" . $fact['fact_name'] . "] but got [$currentCellValue]";
                        $result = false;
                    }
                }
            }
        }

        return $result;
    }
}


/** Validates a folder of .xlsx files */
if (!function_exists('validate_folder')) {
    function validate_folder($mapper, $folder_path, &$error_message)
    {
        #print("\nValidating folder $folder_path");

        if (!file_exists($folder_path)) {
            $error_message = "Folder $folder_path not found!";
            return false;
        }

        if (!is_dir($folder_path)) {
            $error_message = "Path $folder_path does not point to a folder!";
            return false;
        }

        $result = true;


        $filepaths = glob($folder_path . DIRECTORY_SEPARATOR . '*.xlsx');

        foreach ($filepaths as $filepath) {
            #print("\n\tFile path: $filepath");
            $file_error_message = '';
            if (!validate_file($mapper, $filepath, $file_error_message)) {
                $error_message .= "\nFile: $filepath is broken";
                $error_message .= "\n\tCell errors: $file_error_message";
                $result = false;
            }
        }
        #print("\nDone");


        return $result;
    }
}


if (!function_exists('getFinancialValidationMapper')) {
    function getFinancialValidationMapper()
    {
        //Mapper used for validating an XLXS file
        $mapper2 = [
            // ['fact_cell' => 'B2', 'fact_name' => 'Official club name', 'fact_value' => ''],
            // ['fact_cell' => 'B3', 'fact_name' => 'Address', 'fact_value' => ''],
            // ['fact_cell' => 'B6', 'fact_name' => 'Tel', 'fact_value' => ''],
            // ['fact_cell' => 'B7', 'fact_name' => 'Fax', 'fact_value' => ''],
            // ['fact_cell' => 'B8', 'fact_name' => 'Website', 'fact_value' => ''],
            // ['fact_cell' => 'B9', 'fact_name' => 'Founded', 'fact_value' => ''],
            // ['fact_cell' => 'B10', 'fact_name' => 'Members', 'fact_value' => ''],
            // ['fact_cell' => 'B11', 'fact_name' => 'Owner(s)', 'fact_value' => ''],
            // ['fact_cell' => 'B12', 'fact_name' => 'President (Chairman)', 'fact_value' => ''],
            // ['fact_cell' => 'B13', 'fact_name' => 'Manager', 'fact_value' => ''],
            // ['fact_cell' => 'B14', 'fact_name' => 'No. Employees', 'fact_value' => ''],
            // ['fact_cell' => 'B15', 'fact_name' => 'Squad size', 'fact_value' => ''],
            // ['fact_cell' => 'B16', 'fact_name' => 'Average age', 'fact_value' => ''],
            // ['fact_cell' => 'B17', 'fact_name' => 'Foreign Players', 'fact_value' => ''],
            // ['fact_cell' => 'B18', 'fact_name' => 'Foreign Players % of Squad', 'fact_value' => ''],
            // ['fact_cell' => 'B19', 'fact_name' => 'Nation Team Players', 'fact_value' => ''],
            // ['fact_cell' => 'B20', 'fact_name' => 'Stadium Name', 'fact_value' => ''],
            // ['fact_cell' => 'B21', 'fact_name' => 'Capacity', 'fact_value' => ''],
            // ['fact_cell' => 'B22', 'fact_name' => 'League', 'fact_value' => ''],
            // ['fact_cell' => 'B23', 'fact_name' => 'Number of years in league', 'fact_value' => ''],
            // ['fact_cell' => 'B24', 'fact_name' => 'Total Market Value (in pounds)', 'fact_value' => ''],
            // ['fact_cell' => 'C27', 'fact_name' => 'Main Club Honour', 'fact_value' => ''],
            // ['fact_cell' => 'B28', 'fact_name' => 'League Titles', 'fact_value' => ''],
            // ['fact_cell' => 'B29', 'fact_name' => 'National Cup', 'fact_value' => ''],
            // ['fact_cell' => 'B30', 'fact_name' => 'Champions League', 'fact_value' => ''],
            // ['fact_cell' => 'B31', 'fact_name' => 'Europa Leagues', 'fact_value' => ''],
            // ['fact_cell' => 'B32', 'fact_name' => 'Europa Conference', 'fact_value' => ''],
            // ['fact_cell' => 'C34', 'fact_name' => 'Current Sponsors', 'fact_value' => ''],
            // ['fact_cell' => 'B41', 'fact_name' => 'Facebook', 'fact_value' => ''],
            // ['fact_cell' => 'B42', 'fact_name' => 'Instagram', 'fact_value' => ''],
            // ['fact_cell' => 'B43', 'fact_name' => 'Twitter', 'fact_value' => ''],
            // ['fact_cell' => 'B44', 'fact_name' => 'Linkedin', 'fact_value' => ''],

            // ['fact_cell' => 'D46', 'fact_name' => 'Year', 'fact_value' => ''],
            // ['fact_cell' => 'C47', 'fact_name' => 'Competition Position Finish', 'fact_value' => ''],
            // ['fact_cell' => 'D47', 'fact_name' => '2020/21', 'fact_value' => ''],
            // ['fact_cell' => 'E47', 'fact_name' => '2019/20', 'fact_value' => ''],
            // ['fact_cell' => 'F47', 'fact_name' => '2018/19', 'fact_value' => ''],
            // ['fact_cell' => 'G47', 'fact_name' => '2017/18', 'fact_value' => ''],
            // ['fact_cell' => 'C48', 'fact_name' => 'League', 'fact_value' => ''],
            // ['fact_cell' => 'C49', 'fact_name' => ['FA Cup', 'DFB-Pokal', 'Copa Del Rey'], 'fact_value' => ''],
            // ['fact_cell' => 'C50', 'fact_name' => ['EFL Cup', 'Champions League'], 'fact_value' => ''],
            // ['fact_cell' => 'C51', 'fact_name' => ['Champions League', 'Europa League'], 'fact_value' => ''],
            // ['fact_cell' => 'C52', 'fact_name' => 'Europa League', 'fact_value' => ''],

            // ['fact_cell' => 'D54', 'fact_name' => 'Player Trading', 'fact_value' => ''],
            // ['fact_cell' => 'D55', 'fact_name' => '2020/21', 'fact_value' => ''],
            // ['fact_cell' => 'E55', 'fact_name' => '2019/20', 'fact_value' => ''],
            // ['fact_cell' => 'F55', 'fact_name' => '2018/19', 'fact_value' => ''],
            // ['fact_cell' => 'G55', 'fact_name' => '2017/18', 'fact_value' => ''],
            // ['fact_cell' => 'C56', 'fact_name' => 'Player Bought', 'fact_value' => ''],
            // ['fact_cell' => 'C57', 'fact_name' => 'Players Sold', 'fact_value' => ''],
            // ['fact_cell' => 'C58', 'fact_name' => 'Net Spend/(Sales)', 'fact_value' => ''],
            // ['fact_cell' => 'C59', 'fact_name' => 'Loan Deals - In', 'fact_value' => ''],
            // ['fact_cell' => 'C60', 'fact_name' => 'Loan Deals - Out', 'fact_value' => ''],

            // ['fact_cell' => 'D62', 'fact_name' => '2020/21', 'fact_value' => ''],
            // ['fact_cell' => 'E62', 'fact_name' => '2019/20', 'fact_value' => ''],
            // ['fact_cell' => 'F62', 'fact_name' => '2018/19', 'fact_value' => ''],
            // ['fact_cell' => 'G62', 'fact_name' => '2017/18', 'fact_value' => ''],
            // ['fact_cell' => 'C63', 'fact_name' => 'Managers per year', 'fact_value' => ''],
        ];

        return $mapper2;
    }
}


/**
 * Validates a single financial file
 * */
if (!function_exists('validate_financial_file')) {
    function validate_financial_file($mapper, $file_path, &$error_message)
    {
        $ignoreEmptyCells = true;

        if (!file_exists($file_path)) {
            $error_message = 'File not found!';
            return false;
        }

        if (strtolower(pathinfo($file_path, PATHINFO_EXTENSION)) != "xlsx") {
            $error_message = 'File is not a XLSX!';
            return false;
        }

        //Load spreadsheet
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = IOFactory::load($file_path);

        $result = true;

        //TODO: add code

        return $result;
    }
}

/** Validates a folder of .xlsx financail files */
if (!function_exists('validate_financial_folder')) {
    function validate_financial_folder($mapper, $folder_path, &$error_message)
    {
        #print("\nValidating folder $folder_path");

        if (!file_exists($folder_path)) {
            $error_message = "Folder $folder_path not found!";
            return false;
        }

        if (!is_dir($folder_path)) {
            $error_message = "Path $folder_path does not point to a folder!";
            return false;
        }

        $result = true;


        $filepaths = glob($folder_path . DIRECTORY_SEPARATOR . '*.xlsx');

        foreach ($filepaths as $filepath) {
            #print("\n\tFile path: $filepath");
            $file_error_message = '';
            if (!validate_financial_file($mapper, $filepath, $file_error_message)) {
                $error_message .= "\nFile: $filepath is broken";
                $error_message .= "\n\tCell errors: $file_error_message";
                $result = false;
            }
        }
        #print("\nDone");


        return $result;
    }
}
