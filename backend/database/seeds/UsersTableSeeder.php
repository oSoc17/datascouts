<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'john.doe@mail.dom',
            'password' => app('hash')->make('john.doe'),
            'role' => 'admin'
        ]);
        $faker = Faker::create();
        foreach (range(1,5) as $index) {
            $name = $faker->firstName();
            DB::table('users')->insert([
                'name' => $name,
                'email' => $faker->email(),
                'password' => app('hash')->make($name),
            ]);
        }
        
    }
}
