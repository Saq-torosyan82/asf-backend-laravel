<?php

namespace App\Containers\AppSection\Financial\Data\Seeders;

use App\Containers\AppSection\Financial\Tasks\CreateFinancialItemTask;
use App\Containers\AppSection\Financial\Tasks\CreateFinancialSectionTask;
use App\Ship\Parents\Seeders\Seeder;

class FinancialKeyMetricSeeder_8 extends Seeder
{
    public function run()
    {
        $financialSections = [
            [
                'id' => 4,
                'label' => 'Key metrics',
                'index' => 4,
                'nb_years' => 3
            ],
        ];

        foreach ($financialSections as $financialSection) {
            app(CreateFinancialSectionTask::class)->run($financialSection);
        }

        $items = [
            // Ket metrics sheet
            [
                'label'      => "Average attendance",
                'section_id' => 4,
                'group_id'   => 1,
                'subs'       => [
                    "Unused capacity",
                    "Total capacity",
                    "Utilisation rate %",
                ],
            ],
            [
                'label'      => "Sales",
                'section_id' => 4,
                'group_id'   => 2,
                'subs'       => [
                    "Acquisitions",
                ],
            ],
        ];
        foreach ($items as $item) {
            $index = 1;
            if (!empty($item['label'])) {
                app(CreateFinancialItemTask::class)->run([
                    'label' => $item['label'],
                    'item_slag' => self::makeSlag($item['label']),
                    'section_id' => $item['section_id'],
                    'group_id' => $item['group_id'],
                    'index' => $index,
                    'style' => isset($item['style']) ?: ''
                ]);

                ++$index;
            }
            if (!empty($item['subs'])) {
                foreach ($item['subs'] as $label) {
                    app(CreateFinancialItemTask::class)->run([
                        'label'      => $label,
                        'item_slag'  => self::makeSlag($label),
                        'section_id' => $item['section_id'],
                        'group_id'   => $item['group_id'],
                        'index'      => $index,
                        'style'      => ''
                    ]);

                    ++$index;
                }
            }
        }
    }
    private static function makeSlag($label)
    {
        $slag = preg_replace("/[^\w]/", "-", strtolower(trim($label)));
        return preg_replace("/-+/", "-", trim($slag, '-'));
    }
}
