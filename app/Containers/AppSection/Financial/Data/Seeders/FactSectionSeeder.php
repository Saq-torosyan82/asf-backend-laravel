<?php

namespace App\Containers\AppSection\Financial\Data\Seeders;

use App\Containers\AppSection\Financial\Tasks\CreateFactSectionTask;
use App\Ship\Parents\Seeders\Seeder;

class FactSectionSeeder extends Seeder
{
    public function run()
    {
        \DB::table('fact_sections')->delete();

        $sections = [
            'Main Club Honours', 
            'Current Sponsors', 
            'Social Media', 
            'Competition Position Finish', 
            'Player Trading' , 
            'Managers per year'];        

        $i = 1;
        foreach ($sections as $section) {
            app(CreateFactSectionTask::class)->run(['id' => $i, 'name' => $section]);
            ++$i;
        }
    }
}
