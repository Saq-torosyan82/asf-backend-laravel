<?php

namespace App\Containers\AppSection\System\UI\WEB\Controllers;

use App\Ship\Parents\Controllers\WebController;

class Controller extends WebController
{
    public function logoAsset(string $folder, string $file): string
    {
        $path = storage_path('app/public/logo/' . $folder  . '/' . $file);
        if(!file_exists($path)) {
            return abort(404);
        }
        
        dd($folder, $file);
    }
}
