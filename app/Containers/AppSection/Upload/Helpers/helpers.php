<?php

use Illuminate\Support\Arr;

if (!function_exists('downloadUrl')) {
    function downloadUrl(string $uuid): string
    {
        return route('api_upload_download', ['uuid' => $uuid]);
    }
}
