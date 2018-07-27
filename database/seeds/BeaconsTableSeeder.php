<?php

use Illuminate\Database\Seeder;
use App\Beacon;

class BeaconsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		$faker = \Faker\Factory::create();
		for($i = 0; $i < 5; $i++){
			Beacon::create([
				'hw_id' => $faker->iban(null),
				'alias' => $faker->company,
				'ubicacion' => $faker->latitude().",".$faker->longitude(),
			]);
		}

    }
}
