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
            ['name' => 'Facebook', "link" => "https://facebook.com"],
            ['name' => 'Twitter', "link" => "https://twitter.com" ],
            ['name' => 'Youtube', "link" => "https://youtube.com" ],
            ['name' => 'GitHub', "link" => "https://github.com" ],
        ];


        foreach ($services as $service) {
            DB::table('services')->insert(compact('service'));
        }
    }
}


