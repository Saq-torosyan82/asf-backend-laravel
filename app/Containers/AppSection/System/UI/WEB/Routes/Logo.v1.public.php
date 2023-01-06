<?php

use App\Containers\AppSection\System\UI\WEB\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('storage/logo/{folder}/{file}', [Controller::class, 'logoAsset'])
    ->name('web_system_logo_asset')
    ->middleware();

