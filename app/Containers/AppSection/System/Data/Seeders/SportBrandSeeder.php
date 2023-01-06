<?php

namespace App\Containers\AppSection\System\Data\Seeders;

use App\Containers\AppSection\System\Tasks\CreateSportBrandTask;
use App\Ship\Parents\Seeders\Seeder;

class SportBrandSeeder extends Seeder
{
    public function run()
    {
        \DB::table('sport_brands')->delete();

        $sport_brands = [

            [
                'id' => 1,
                'name' => 'Nike',
                'logo' => 'nike.jpg',
            ],
            [
                'id' => 2,
                'name' => 'Adidas',
                'logo' => 'adidas.png',
            ],
            [
                'id' => 3,
                'name' => 'Macron ',
                'logo' => 'macron.png',
            ],
            [
                'id' => 4,
                'name' => 'Hummel',
                'logo' => 'hummel.png',
            ],
            [
                'id' => 5,
                'name' => 'Puma',
                'logo' => 'puma.png',
            ],
            [
                'id' => 6,
                'name' => 'Under armour',
                'logo' => 'under-armour.jpg',
            ],
            [
                'id' => 7,
                'name' => 'New balance',
                'logo' => 'new-balance.png',
            ],
            [
                'id' => 8,
                'name' => 'Luluemon athletica',
                'logo' => 'lululemon-athletica.png',
            ],
            [
                'id' => 9,
                'name' => 'Kappa',
                'logo' => 'kappa.png',
            ],
            [
                'id' => 10,
                'name' => 'Columbia sportswear',
                'logo' => 'columbia.png',
            ],
            [
                'id' => 11,
                'name' => 'Asics ',
                'logo' => 'asics.png',
            ],
            [
                'id' => 12,
                'name' => 'Reebok',
                'logo' => 'reebok.png',
            ],
            [
                'id' => 13,
                'name' => 'Fila',
                'logo' => 'fila.png',
            ],
            [
                'id' => 14,
                'name' => 'Champion',
                'logo' => 'champion.png',
            ],
            [
                'id' => 15,
                'name' => 'Diadora',
                'logo' => 'diadora.png',
            ],
            [
                'id' => 16,
                'name' => 'Ellesse',
                'logo' => 'ellesse.png',
            ],
            [
                'id' => 17,
                'name' => 'Hoka one one',
                'logo' => '',
            ],
            [
                'id' => 18,
                'name' => 'Jordan',
                'logo' => 'air-jordan.png',
            ],
            [
                'id' => 19,
                'name' => 'Lacoste',
                'logo' => 'lacoste.png',
            ],
            [
                'id' => 20,
                'name' => 'Le coq sportif',
                'logo' => 'le-coq-sportif.png',
            ],
            [
                'id' => 21,
                'name' => 'Oakley',
                'logo' => 'oakley.png',
            ],
            [
                'id' => 22,
                'name' => 'Sergio Tacchini',
                'logo' => 'sergio-tacchini.png',
            ],
            [
                'id' => 23,
                'name' => 'Umbro',
                'logo' => 'umbro.png',
            ],
            [
                'id' => 24,
                'name' => 'Castore',
                'logo' => 'castore.png',
            ],
            [
                'id' => 25,
                'name' => 'Capelli',
                'logo' => 'capelli-sport.png',
            ],
            [
                'id' => 26,
                'name' => 'Beltona',
                'logo' => 'beltona.png',
            ],
            [
                'id' => 27,
                'name' => 'Charly',
                'logo' => 'charly.png',
            ],
            [
                'id' => 28,
                'name' => 'Joma',
                'logo' => 'joma.png',
            ],
            [
                'id' => 29,
                'name' => 'Kelme',
                'logo' => 'kelme.png',
            ],
            [
                'id' => 30,
                'name' => 'Uhlsport',
                'logo' => 'uhlsport.png',
            ],
            [
                'id' => 31,
                'name' => 'Athleta',
                'logo' => 'athleta.png',
            ],
            [
                'id' => 32,
                'name' => 'Old Navy',
                'logo' => 'old-navy.png',
            ],
            [
                'id' => 33,
                'name' => 'GAP',
                'logo' => '',
            ],
            [
                'id' => 34,
                'name' => 'Fabletics',
                'logo' => 'fabletics.jpg',
            ],
            [
                'id' => 35,
                'name' => 'Patagonia',
                'logo' => 'patagonia.png',
            ],
            [
                'id' => 36,
                'name' => 'Wilson',
                'logo' => 'wilson.jpg',
            ],
            [
                'id' => 37,
                'name' => 'Taylor Made',
                'logo' => 'taylormade.jpg',
            ],
            [
                'id' => 38,
                'name' => 'Callaway',
                'logo' => 'callaway.png',
            ],
            [
                'id' => 39,
                'name' => 'Uniqlo ',
                'logo' => 'uniqlo.png',
            ],
            [
                'id' => 40,
                'name' => 'Titleist ',
                'logo' => 'titleist.png',
            ],
            [
                'id' => 41,
                'name' => 'Admiral',
                'logo' => 'admiral.webp',
            ],
            [
                'id' => 42,
                'name' => 'Errea',
                'logo' => 'errea.png',
            ],
            [
                'id' => 43,
                'name' => 'Canterbury',
                'logo' => 'canterbury.png',
            ],
            [
                'id' => 44,
                'name' => 'Warrior',
                'logo' => 'warrior.png',
            ],
            [
                'id' => 45,
                'name' => 'Everlast',
                'logo' => 'everlast.png',
            ],
        ];

        foreach ($sport_brands as $sport_brand) {
            app(CreateSportBrandTask::class)->run($sport_brand);
        }
    }
}
