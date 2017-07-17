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
        $faker = Faker::create();
        foreach (range(1,3) as $i) {
            DB::table('handles')->insert([
                'name' => $faker->unique()->sentence(4, TRUE),
                'url' => $faker->unique()->url(),
                'entity_id' => $i,
                'service_id' => 2,
                'provider_id' => $i
            ]);
        }

    }
}
