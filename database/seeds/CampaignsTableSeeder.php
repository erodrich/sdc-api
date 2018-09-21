<?php

use Illuminate\Database\Seeder;

class CampaignsTableSeeder extends Seeder
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

		for($i = 0; $i < 10; $i++){
			App\Campaign::create([
				'name' => $faker->catchPhrase,
                'start_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
				'end_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'active' => true,
                'client_id' => App\Client::find(rand(1,10))->id,
			]);
		}
    }
}
