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
        $campaign = \App\Campaign::all();
		for($i = 0; $i < 10; $i++){
			App\Ad::create([
				'title' => $faker->sentence(),
				'description' => $faker->sentence(),
                'image_full_name' => $faker->sentence(),
				'image_pre_name' => $faker->sentence(),
				'image_full_url' => "https://picsum.photos/640/480/?random",
				'image_pre_url' => "https://picsum.photos/640/120/?random",
                'campaign_id' => $campaign->random()->first()->id,
                'video_url' => "https://www.youtube.com/watch?v=YN2URsx8gIs",
                'link_url' => "http://www.google.com",
                'content' => $faker->text(),
			]);
		}
    }
}
