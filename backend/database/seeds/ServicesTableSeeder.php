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
            ['name' => 'twitter', "link" => "https://twitter.com" ],
            ['name' => 'youtube', "link" => "https://youtube.com" ],
            ['name' => 'vimeo', "link" => "https://vimeo.com" ],
            ['name' => 'github', "link" => "https://github.com" ],
        ];


        foreach ($services as $service) {
            DB::table('services')->insert(compact('service'));
        }
    }
}


