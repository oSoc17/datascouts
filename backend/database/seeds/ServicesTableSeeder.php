<?php

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            ['name' => 'Facebook', "url" => "https://facebook.com"],
            ['name' => 'Twitter', "url" => "https://twitter.com" ],
            ['name' => 'Youtube', "url" => "https://youtube.com" ],
            ['name' => 'GitHub', "url" => "https://github.com" ],
        ];


        foreach ($services as $service) {
            DB::table('services')->insert(compact('service'));
        }
    }
}


