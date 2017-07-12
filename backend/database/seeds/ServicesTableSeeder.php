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
            ['name' => 'Facebook', "url" => "https://facebook.com", "logo" => null, "logo_url" => "" ],
            ['name' => 'Twitter', "url" => "https://twitter.com" ],
            ['name' => 'Youtube', "url" => "https://youtube.com" ],
            ['name' => 'Github', "url" => "https://github.com" ],
        ];

        foreach ($services as $service) {
            var_dump($service);
            DB::table('services')->insert(compact($service));
        }
    }
}
