<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class HandlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $handles = ['osoc17', 'crypo blockchain', 'starbucks'];
        $faker = Faker::create();
        foreach (range(1,3) as $i) {
            DB::table('handles')->insert([
                'name' => $handles[$i-1] ,
                'url' => $faker->unique()->url(),
                'entity_id' => $i,
                'service_id' => 2
            ]);
        }

    }
}
