<?php

use Illuminate\Database\Seeder;

class AdsTableSeeder extends Seeder
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
			App\Ad::create([
				'title' => $faker->sentence(),
				'subtitle' => $faker->sentence(),
                'image_full_name' => $faker->sentence(),
				'image_pre_name' => $faker->sentence(),
				'image_full_url' => "https://picsum.photos/640/4800/?random",
				'image_pre_url' => "https://picsum.photos/640/120/?random",
                'campaign_id' => App\Campaign::find(rand(1,10))->id,
			]);
		}
    }
}
