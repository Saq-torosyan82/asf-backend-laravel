<?php

namespace App\Ship\Parents\Tasks;

use Illuminate\Support\Facades\DB;

class FindEntityByTableAndIdTask extends Task
{
    public function run(string $tableName, int $id) {
        return DB::table($tableName)->find($id);
    }
}
