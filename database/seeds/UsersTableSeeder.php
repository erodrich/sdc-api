<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		//App\User::truncate();
		$faker = \Faker\Factory::create();
		$password = Hash::make('password');

		App\User::create([
			'name' => 'admin',
			'email' => 'admin@sdc-api.com',
			'password' => $password,
			'client_id' => App\Client::find(rand(1,10))->id,
		]);
		App\User::create([
			'name' => 'erodrich',
			'email' => 'erodrich@sdc-api.com',
			'password' => $password,
			'client_id' => App\Client::find(rand(1,10))->id,
		]);
		
		for($i = 0; $i < 10; $i++){
			App\User::create([
				'name' => $faker->name,
				'email' => $faker->email,
				'password' => $password,
				'client_id' => App\Client::find(rand(1,10))->id,
			]);
		}
    }
}
