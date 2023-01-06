<?php

namespace App\Containers\AppSection\System\Data\Seeders;

use App\Containers\AppSection\System\Tasks\CreateSportSponsorTask;
use App\Ship\Parents\Seeders\Seeder;

class SportSponsorSeeder extends Seeder
{
    public function run()
    {
        \DB::table('sport_sponsors')->delete();

        $sportSponsors = [
            [
                'id' => 1,
                'name' => 'Yokohama',
                'logo' => 'yokohama.png'
            ],
            [
                'id' => 2,
                'name' => 'Chevrolet',
                'logo' => 'chevrolet.png',
            ],
            [
                'id' => 3,
                'name' => 'Etihad',
                'logo' => 'etihad.png',
            ],
            [
                'id' => 4,
                'name' => 'Qatar Airways',
                'logo' => 'qatar-airways.png',
            ],
            [
                'id' => 5,
                'name' => 'T mobile',
                'logo' => 't-mobile.png',
            ],
            [
                'id' => 6,
                'name' => 'Bet365',
                'logo' => 'bet365.png',
            ],
            [
                'id' => 7,
                'name' => 'Betano',
                'logo' => 'betano.png',
            ],
            [
                'id' => 8,
                'name' => 'Dafabet',
                'logo' => 'dafabet.png',
            ],
            [
                'id' => 9,
                'name' => 'King Power',
                'logo' => 'king-power.jpg',
            ],
            [
                'id' => 10,
                'name' => 'Betfred',
                'logo' => 'betfred.png',
            ],
            [
                'id' => 11,
                'name' => 'Volkswagen',
                'logo' => 'volkswagen.png',
            ],
            [
                'id' => 12,
                'name' => 'Samsung',
                'logo' => 'samsung.png',
            ],
            [
                'id' => 13,
                'name' => 'Evonik',
                'logo' => 'evonik.png',
            ],
            [
                'id' => 14,
                'name' => 'Deutsche Telekom',
                'logo' => 'deutche-telekom.svg',
            ],
            [
                'id' => 15,
                'name' => 'O2',
                'logo' => 'o2.png',
            ],
            [
                'id' => 16,
                'name' => 'Vodafone',
                'logo' => 'vodafone.png',
            ],
            [
                'id' => 17,
                'name' => 'Tag Heuer',
                'logo' => 'tag-heuer.png',
            ],
            [
                'id' => 18,
                'name' => 'Jaguar',
                'logo' => 'jaguar.png',
            ],
            [
                'id' => 19,
                'name' => 'P&G',
                'logo' => 'p&g.png',
            ],
            [
                'id' => 20,
                'name' => 'Omega',
                'logo' => 'omega.png',
            ],
            [
                'id' => 21,
                'name' => 'Beats',
                'logo' => 'beats.png',
            ],
            [
                'id' => 22,
                'name' => 'Panini',
                'logo' => 'panini.png',
            ],
            [
                'id' => 23,
                'name' => 'BBVA',
                'logo' => 'bbva.png',
            ],
            [
                'id' => 24,
                'name' => 'Rolex',
                'logo' => 'rolex.png',
            ],
            [
                'id' => 25,
                'name' => 'Verizon',
                'logo' => 'verizon.png',
            ],
            [
                'id' => 26,
                'name' => 'Nissan',
                'logo' => 'nissan.png',
            ],
            [
                'id' => 27,
                'name' => 'Ford',
                'logo' => 'ford.png',
            ],
            [
                'id' => 28,
                'name' => 'Coca Cola',
                'logo' => '',
            ],
            [
                'id' => 29,
                'name' => 'Pepsi',
                'logo' => 'pepsi.png',
            ],
            [
                'id' => 30,
                'name' => 'Kia Motors',
                'logo' => 'kia.png',
            ],
            [
                'id' => 31,
                'name' => 'Bridgestone',
                'logo' => 'bridgestone.png',
            ],
            [
                'id' => 32,
                'name' => 'Mercedes',
                'logo' => 'mercedes.png',
            ],
            [
                'id' => 33,
                'name' => 'BMW',
                'logo' => 'bmw.png',
            ],
            [
                'id' => 34,
                'name' => 'AT&T',
                'logo' => 'at&t.png',
            ],
            [
                'id' => 35,
                'name' => 'Toyota',
                'logo' => 'toyota.png',
            ],
            [
                'id' => 36,
                'name' => 'General Motors',
                'logo' => 'general-motors.png',
            ],
            [
                'id' => 37,
                'name' => 'EA Sports',
                'logo' => 'ea-sports.png',
            ],
            [
                'id' => 38,
                'name' => 'VISA',
                'logo' => 'visa.png',
            ],
            [
                'id' => 39,
                'name' => 'Mastercard',
                'logo' => 'mastercard.png',
            ],
            [
                'id' => 40,
                'name' => 'Gatorade',
                'logo' => 'gatorade.png',
            ],
            [
                'id' => 41,
                'name' => 'Huawei',
                'logo' => 'huawei.png',
            ],
            [
                'id' => 42,
                'name' => 'Santander',
                'logo' => 'santander.png',
            ],
            [
                'id' => 43,
                'name' => 'Barclays',
                'logo' => 'barclays.png',
            ],
            [
                'id' => 44,
                'name' => 'Bose',
                'logo' => 'bose.png',
            ],
            [
                'id' => 45,
                'name' => 'Gillette',
                'logo' => 'gillette.png',
            ],
            [
                'id' => 46,
                'name' => 'QNB',
                'logo' => 'qnb.png',
            ],
            [
                'id' => 47,
                'name' => 'Telefónica',
                'logo' => 'telefonica.png',
            ],
            [
                'id' => 48,
                'name' => 'American family insurance',
                'logo' => 'american-family-insurance.png',
            ],
            [
                'id' => 49,
                'name' => 'State Farm',
                'logo' => 'statefarm.png',
            ],
            [
                'id' => 50,
                'name' => 'Monster Energy',
                'logo' => 'monster-energy.png',
            ],
            [
                'id' => 51,
                'name' => 'L’Oréal',
                'logo' => 'l\'oreal.png',
            ],
            [
                'id' => 52,
                'name' => 'Tommy Hilfiger',
                'logo' => 'tommy-hilfiger.png',
            ],
            [
                'id' => 53,
                'name' => 'Sony',
                'logo' => 'sony.png',
            ],
            [
                'id' => 54,
                'name' => 'Hugo Boss',
                'logo' => 'hugo-boss.png',
            ],
            [
                'id' => 55,
                'name' => 'Red Bull',
                'logo' => 'red-bull.png',
            ],
            [
                'id' => 56,
                'name' => 'BT Sport',
                'logo' => 'bt-sport.png',
            ],
            [
                'id' => 57,
                'name' => 'Wish',
                'logo' => 'wish.png',
            ],
            [
                'id' => 58,
                'name' => 'Footlocker',
                'logo' => 'footlocker.png',
            ],
            [
                'id' => 59,
                'name' => 'British Airways',
                'logo' => 'british-airways.png',
            ],
            [
                'id' => 60,
                'name' => 'Delta Airlines',
                'logo' => 'delta-airlines.png'
            ],
            [
                'id' => 61,
                'name' => 'AIA',
                'logo' => 'aia.png',
            ],
            [
                'id' => 62,
                'name' => 'Betway',
                'logo' => 'betway.png',
            ],
            [
                'id' => 63,
                'name' => 'Crefisa',
                'logo' => 'crefisa.png',
            ],
            [
                'id' => 64,
                'name' => 'Emaar',
                'logo' => 'emaar.png',
            ],
            [
                'id' => 65,
                'name' => 'Emirates Airlines',
                'logo' => 'emirates-airline.png',
            ],
            [
                'id' => 66,
                'name' => 'Gazprom',
                'logo' => 'gazprom.png',
            ],
            [
                'id' => 67,
                'name' => 'Jeep',
                'logo' => 'jeep.png',
            ],
            [
                'id' => 68,
                'name' => 'Mapei',
                'logo' => 'mapei.png',
            ],
            [
                'id' => 69,
                'name' => 'Plus500',
                'logo' => 'plus500.png',
            ],
            [
                'id' => 70,
                'name' => 'Rakuten',
                'logo' => 'rakuten.png',
            ],
            [
                'id' => 71,
                'name' => 'Standard Chartered',
                'logo' => 'standard-chartered.png',
            ],
            [
                'id' => 72,
                'name' => 'TeamViewer',
                'logo' => 'teamviewer.png',
            ],
            [
                'id' => 73,
                'name' => 'Ziggo',
                'logo' => 'ziggo.png',
            ],
            [
                'id' => 74,
                'name' => 'Cazoo',
                'logo' => 'cazoo.png',
            ],
            [
                'id' => 75,
                'name' => 'Flatex',
                'logo' => 'flatex.png'
            ],
            [
                'id' => 76,
                'name' => 'American Express',
                'logo' => 'american-express.png',
            ],
            [
                'id' => 77,
                'name' => 'Lovebet.com ',
                'logo' => 'lovabet.com.png',
            ],
            [
                'id' => 78,
                'name' => 'Sportsbet.io',
                'logo' => 'sportsbet.io.png',
            ],
            [
                'id' => 79,
                'name' => 'Autohero',
                'logo' => 'autohero.png',
            ],
            [
                'id' => 80,
                'name' => 'Indeed',
                'logo' => 'indeed.png',
            ],
            [
                'id' => 81,
                'name' => 'SBOTOP',
                'logo' => 'sbotop.png',
            ],
            [
                'id' => 82,
                'name' => '1&1',
                'logo' => '1&1.png',
            ],
            [
                'id' => 83,
                'name' => 'Three',
                'logo' => '3.png',
            ],
        ];

        foreach ($sportSponsors as $key => $sportSponsor) {
            app(CreateSportSponsorTask::class)->run($sportSponsor);
        }
    }
}
