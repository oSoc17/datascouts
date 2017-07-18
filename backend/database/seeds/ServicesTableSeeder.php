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
<<<<<<< HEAD
            ['name' => 'Facebook', "link" => "https://facebook.com"],
            ['name' => 'Twitter', "link" => "https://twitter.com" ],
            ['name' => 'Youtube', "link" => "https://youtube.com" ],
            ['name' => 'GitHub', "link" => "https://github.com" ],
=======
            ['name' => 'Facebook', "url" => "https://facebook.com"],
            ['name' => 'Twitter', "url" => "https://twitter.com" ],
            ['name' => 'Youtube', "url" => "https://youtube.com" ],
            ['name' => 'GitHub', "url" => "https://github.com" ],
>>>>>>> feature/72-backend-crud-services
        ];


        foreach ($services as $service) {
            DB::table('services')->insert(compact('service'));
        }
    }
}


