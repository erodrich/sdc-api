<?php

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		
	    	$faker = \Faker\Factory::create();

		App\Client::create([
			'name' => 'SDC Company',
			'ruc' => '10111111110',
			'description' => 'SDC Distribución de contenido digital'
		]);
		/*
		for($i = 0; $i < 10; $i++){
			App\Client::create([
				'name' => $faker->company,
				'ruc' => '01010101010',
				'description' => $faker->sentence,
			]);
		}
		 */
		
    }
}
