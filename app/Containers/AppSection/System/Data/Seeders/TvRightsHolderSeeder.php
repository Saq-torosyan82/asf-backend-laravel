<?php

namespace App\Containers\AppSection\System\Data\Seeders;

use App\Containers\AppSection\System\Tasks\CreateTvRightsHolderTask;
use App\Ship\Parents\Seeders\Seeder;

class TvRightsHolderSeeder extends Seeder
{
    public function run()
    {
        \DB::table('tv_rights_holders')->delete();

        $tv_rights_holders = [
            [
                'id' => 1,
                'name' => 'Sky Sports',
                'logo' => 'sky-sports.png',
            ],
            [
                'id' => 2,
                'name' => 'BT sports',
                'logo' => 'bt-sports.png',
            ],
            [
                'id' => 3,
                'name' => 'Amazon Prime',
                'logo' => 'amazon-prime.png',
            ],
            [
                'id' => 4,
                'name' => 'DAZN',
                'logo' => 'dazn.png',
            ],
            [
                'id' => 5,
                'name' => 'Sky Italia ',
                'logo' => 'sky-italia.png',
            ],
            [
                'id' => 6,
                'name' => 'Media Pro',
                'logo' => 'media-pro.png',
            ],
            [
                'id' => 7,
                'name' => 'Movistar',
                'logo' => 'movistar.svg',
            ],
            [
                'id' => 8,
                'name' => 'Eurosport',
                'logo' => 'eurosport.png',
            ],
            [
                'id' => 9,
                'name' => 'Sky Germany',
                'logo' => 'sky-germany.png',
            ],
            [
                'id' => 10,
                'name' => 'ESPN',
                'logo' => '',
            ],
            [
                'id' => 11,
                'name' => 'FOX Sports',
                'logo' => 'fox-sports.png',
            ],
            [
                'id' => 12,
                'name' => 'TBS',
                'logo' => 'tbs.png',
            ],
            [
                'id' => 13,
                'name' => 'TNT Sports',
                'logo' => 'tnt-sports.png',
            ],
            [
                'id' => 14,
                'name' => 'Turner ',
                'logo' => 'turner.png',
            ],
            [
                'id' => 15,
                'name' => 'Sony Network',
                'logo' => 'sony-pictures.png',
            ],
            [
                'id' => 16,
                'name' => 'Roger Sportnet',
                'logo' => 'rogers-sportnet.png',
            ],
            [
                'id' => 17,
                'name' => 'BeIN Sports',
                'logo' => 'bein-sport.png',
            ],
            [
                'id' => 18,
                'name' => 'ZDF',
                'logo' => 'zdf.png',
            ],
            [
                'id' => 19,
                'name' => 'Telefonica',
                'logo' => 'telefónica.png',
            ],
            [
                'id' => 20,
                'name' => 'Digiturk',
                'logo' => 'digiturk.png',
            ],
            [
                'id' => 21,
                'name' => 'Globosat',
                'logo' => 'globosat.png',
            ],
            [
                'id' => 22,
                'name' => 'Sport TV',
                'logo' => 'sport-tv-1-hd.png',
            ],
            [
                'id' => 23,
                'name' => 'Benfica TV',
                'logo' => 'benfica-tv.png',
            ],
            [
                'id' => 24,
                'name' => 'Eleven Sports',
                'logo' => 'eleven.png',
            ],
            [
                'id' => 25,
                'name' => 'LookSport',
                'logo' => 'looksport.png',
            ],
            [
                'id' => 26,
                'name' => 'TV3',
                'logo' => 'tv3.png',
            ],
            [
                'id' => 27,
                'name' => 'Canal+',
                'logo' => 'canal+.png',
            ],
            [
                'id' => 28,
                'name' => 'Tele Club',
                'logo' => 'teleclub-sport.png',
            ],
            [
                'id' => 29,
                'name' => 'Sky Osterreich',
                'logo' => 'sky-sport-austria.png',
            ],
        ];

        foreach ($tv_rights_holders as $row) {
            app(CreateTvRightsHolderTask::class)->run($row);
        }
    }
}
