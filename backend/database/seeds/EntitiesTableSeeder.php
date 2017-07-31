<?php

use Illuminate\Database\Seeder;

class EntitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entities = [
            [
                'name' => 'Osoc keywords', "url" => "entities-osoc",
                "image" => "http://2017.summerofcode.be/images/squarelogo-LI.png"
            ],
            ['name' => 'crypto Set', "url" => "entities-crypto-blockchain" ],
            ['name' => 'Startsucks', "url" => "entities-starbucks" ],
        ];

        foreach ($entities as $entity) {
            DB::table('entities')->insert(compact('entity'));
        }
    }
}
