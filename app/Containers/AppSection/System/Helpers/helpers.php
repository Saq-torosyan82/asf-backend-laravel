<?php

use Illuminate\Support\Arr;

if (!function_exists('changeMoneyFormat')) {
    function changeMoneyFormat(string $range)
    {
        $range = strtolower(trim($range));
        $suffix = [
            'k' => 1000,
            'm' => 1000000
        ];
        if (strpos($range,'-') !== false) {
            [$first, $second] = explode('-', $range);
            if (!array_key_exists(substr($first, -1), $suffix)) {
                if (!is_numeric($key = substr($second, -1))){
                    $first .= $key;
                }
            }
            $arrNumbers = [$first, $second];
        } elseif (strpos($range,'to') !== false) {
            [$first, $second] = explode('to', $range);
            if (!array_key_exists(substr($first, -1), $suffix)) {
                if (!is_numeric($key = substr($second, -1))){
                    $first .= $key;
                }
            }
            $arrNumbers = [$first, $second];
        } else {
            $arrNumbers[] = strpos($range,'+') !== false ? substr($range,0, -1) : $range;
        }
        $numbers = [];
        foreach ($arrNumbers as $number) {
            $s = substr($number, -1);
            $numbers[] = !empty($suffix[$s]) ? $suffix[$s] * trim(substr($number, 0,-1)) : $number;
        }
        return $numbers;
    }
}
